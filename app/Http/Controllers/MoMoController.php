<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MoMoController extends Controller
{
    public function createPayment(Order $order)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        
        $partnerCode = env('MOMO_PARTNER_CODE', 'DEMO');
        $accessKey = env('MOMO_ACCESS_KEY', 'DEMO');
        $secretKey = env('MOMO_SECRET_KEY', 'DEMO');
        $orderInfo = "Thanh toán đơn hàng #" . $order->order_number;
        $amount = (string)$order->total;
        $orderId = $order->order_number;
        $redirectUrl = route('momo.return');
        $ipnUrl = route('momo.ipn');
        $extraData = "";
        $requestId = time() . "";
        $requestType = "captureWallet";
        
        // Create raw signature
        $rawHash = "accessKey=" . $accessKey . 
                   "&amount=" . $amount . 
                   "&extraData=" . $extraData . 
                   "&ipnUrl=" . $ipnUrl . 
                   "&orderId=" . $orderId . 
                   "&orderInfo=" . $orderInfo . 
                   "&partnerCode=" . $partnerCode . 
                   "&redirectUrl=" . $redirectUrl . 
                   "&requestId=" . $requestId . 
                   "&requestType=" . $requestType;
        
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);
        
        if (isset($jsonResult['payUrl'])) {
            return redirect($jsonResult['payUrl']);
        }
        
        Log::error('MoMo payment creation failed', ['response' => $jsonResult]);
        return redirect('/checkout')->with('error', 'Không thể tạo thanh toán MoMo. Vui lòng thử lại.');
    }

    public function return(Request $request)
    {
        $secretKey = env('MOMO_SECRET_KEY', 'DEMO');
        
        $partnerCode = $request->partnerCode;
        $orderId = $request->orderId;
        $requestId = $request->requestId;
        $amount = $request->amount;
        $orderInfo = $request->orderInfo;
        $orderType = $request->orderType;
        $transId = $request->transId;
        $resultCode = $request->resultCode;
        $message = $request->message;
        $payType = $request->payType;
        $responseTime = $request->responseTime;
        $extraData = $request->extraData;
        $signature = $request->signature;
        
        // Verify signature
        $rawHash = "accessKey=" . env('MOMO_ACCESS_KEY', 'DEMO') . 
                   "&amount=" . $amount . 
                   "&extraData=" . $extraData . 
                   "&message=" . $message . 
                   "&orderId=" . $orderId . 
                   "&orderInfo=" . $orderInfo .
                   "&orderType=" . $orderType .
                   "&partnerCode=" . $partnerCode .
                   "&payType=" . $payType .
                   "&requestId=" . $requestId .
                   "&responseTime=" . $responseTime .
                   "&resultCode=" . $resultCode .
                   "&transId=" . $transId;
        
        $checkSignature = hash_hmac("sha256", $rawHash, $secretKey);
        
        // Find order
        $order = Order::where('order_number', $orderId)->first();
        
        if (!$order) {
            return redirect('/')->with('error', 'Không tìm thấy đơn hàng');
        }
        
        if ($checkSignature == $signature) {
            if ($resultCode == '0') {
                // Validate amount
                if ($order->total != $amount) {
                    Log::error('MoMo amount mismatch', [
                        'order_number' => $order->order_number,
                        'order_amount' => $order->total,
                        'momo_amount' => $amount
                    ]);
                    return redirect('/checkout')->with('error', 'Số tiền thanh toán không khớp.');
                }

                // Check if already paid
                if ($order->payment_status === 'paid') {
                    Log::warning('MoMo duplicate return attempt', [
                        'order_number' => $order->order_number,
                        'transaction_id' => $transId
                    ]);
                    // Still redirect to success page
                    session()->put('order_confirmation', [
                        'order' => $order,
                        'payment_method_name' => 'Ví MoMo',
                        'payment_method' => 'online',
                        'online_method' => 'momo',
                        'transaction_id' => $transId,
                    ]);
                    return redirect('/order-confirmation')->with('success', 'Thanh toán đã được xử lý!');
                }

                // Payment success
                $order->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $transId,
                    'paid_at' => now(),
                ]);
                
                // Send email to admin
                $this->sendAdminNotification($order);
                
                // Store order info in session for confirmation page
                session()->put('order_confirmation', [
                    'order' => $order,
                    'payment_method_name' => 'Ví MoMo',
                    'payment_method' => 'online',
                    'online_method' => 'momo',
                    'transaction_id' => $transId,
                ]);
                
                return redirect('/order-confirmation')->with('success', 'Thanh toán thành công!');
            } else {
                // Payment failed
                $order->update([
                    'payment_status' => 'pending',
                    'notes' => ($order->notes ? $order->notes . "\n" : '') . 'MoMo payment failed. Code: ' . $resultCode . ' - ' . $message,
                ]);
                
                return redirect('/checkout')->with('error', 'Thanh toán thất bại: ' . $message);
            }
        } else {
            Log::error('MoMo invalid signature', [
                'order_number' => $orderId,
                'response' => $request->all()
            ]);
            return redirect('/')->with('error', 'Chữ ký không hợp lệ');
        }
    }

    public function ipn(Request $request)
    {
        // Handle IPN (Instant Payment Notification) from MoMo
        $secretKey = env('MOMO_SECRET_KEY', 'DEMO');
        
        $partnerCode = $request->partnerCode;
        $orderId = $request->orderId;
        $requestId = $request->requestId;
        $amount = $request->amount;
        $orderInfo = $request->orderInfo;
        $orderType = $request->orderType;
        $transId = $request->transId;
        $resultCode = $request->resultCode;
        $message = $request->message;
        $payType = $request->payType;
        $responseTime = $request->responseTime;
        $extraData = $request->extraData;
        $signature = $request->signature;
        
        // Verify signature
        $rawHash = "accessKey=" . env('MOMO_ACCESS_KEY', 'DEMO') . 
                   "&amount=" . $amount . 
                   "&extraData=" . $extraData . 
                   "&message=" . $message . 
                   "&orderId=" . $orderId . 
                   "&orderInfo=" . $orderInfo .
                   "&orderType=" . $orderType .
                   "&partnerCode=" . $partnerCode .
                   "&payType=" . $payType .
                   "&requestId=" . $requestId .
                   "&responseTime=" . $responseTime .
                   "&resultCode=" . $resultCode .
                   "&transId=" . $transId;
        
        $checkSignature = hash_hmac("sha256", $rawHash, $secretKey);
        
        if ($checkSignature == $signature) {
            $order = Order::where('order_number', $orderId)->first();
            
            if ($order && $resultCode == '0') {
                // Validate amount
                if ($order->total != $amount) {
                    Log::error('MoMo IPN amount mismatch', [
                        'order_number' => $order->order_number,
                        'order_amount' => $order->total,
                        'momo_amount' => $amount
                    ]);
                    return response()->json(['message' => 'Amount mismatch'], 400);
                }

                // Check if already paid
                if ($order->payment_status === 'paid') {
                    Log::warning('MoMo duplicate IPN attempt', [
                        'order_number' => $order->order_number,
                        'transaction_id' => $transId
                    ]);
                    return response()->json(['message' => 'Already processed']);
                }

                $order->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $transId,
                    'paid_at' => now(),
                ]);
                
                Log::info('MoMo IPN processed successfully', ['order_number' => $orderId]);
            }
            
            return response()->json(['message' => 'IPN processed']);
        }
        
        Log::error('MoMo IPN invalid signature', ['request' => $request->all()]);
        return response()->json(['message' => 'Invalid signature'], 400);
    }

    private function sendAdminNotification(Order $order)
    {
        try {
            $adminEmail = env('ADMIN_EMAIL', 'admin@yensaohd.vn');
            
            Mail::send('emails.order-paid', ['order' => $order], function ($message) use ($adminEmail, $order) {
                $message->to($adminEmail)
                        ->subject('Đơn hàng mới đã thanh toán #' . $order->order_number);
            });
        } catch (\Exception $e) {
            Log::error('Failed to send admin notification: ' . $e->getMessage());
        }
    }

    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        
        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
    }
}
