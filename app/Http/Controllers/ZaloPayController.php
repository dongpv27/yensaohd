<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ZaloPayController extends Controller
{
    public function createPayment(Order $order)
    {
        $config = [
            "app_id" => env('ZALOPAY_APP_ID', '2553'),
            "key1" => env('ZALOPAY_KEY1', 'PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL'),
            "key2" => env('ZALOPAY_KEY2', 'kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz'),
            "endpoint" => "https://sb-openapi.zalopay.vn/v2/create"
        ];

        $embeddata = json_encode([
            'redirecturl' => route('zalopay.return')
        ]);

        $items = json_encode([]);
        $transID = time();
        
        $order_data = [
            "app_id" => $config["app_id"],
            "app_trans_id" => date("ymd") . "_" . $transID, // Format: yymmdd_xxxx
            "app_user" => $order->email,
            "app_time" => round(microtime(true) * 1000), // milliseconds
            "item" => $items,
            "embed_data" => $embeddata,
            "amount" => $order->total,
            "description" => "Thanh toán đơn hàng #" . $order->order_number,
            "bank_code" => "",
            "callback_url" => route('zalopay.callback'),
        ];

        // Create mac signature
        $data = $order_data["app_id"] . "|" . 
                $order_data["app_trans_id"] . "|" . 
                $order_data["app_user"] . "|" . 
                $order_data["amount"] . "|" . 
                $order_data["app_time"] . "|" . 
                $order_data["embed_data"] . "|" . 
                $order_data["item"];
        
        $order_data["mac"] = hash_hmac("sha256", $data, $config["key1"]);

        // Store app_trans_id in order notes for later reference
        $order->update([
            'notes' => ($order->notes ? $order->notes . "\n" : '') . 'ZaloPay Transaction ID: ' . $order_data["app_trans_id"]
        ]);

        $context = stream_context_create([
            "http" => [
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => http_build_query($order_data)
            ]
        ]);

        $resp = file_get_contents($config["endpoint"], false, $context);
        $result = json_decode($resp, true);

        if (isset($result['order_url']) && $result['return_code'] == 1) {
            return redirect($result['order_url']);
        }

        Log::error('ZaloPay payment creation failed', ['response' => $result]);
        return redirect('/checkout')->with('error', 'Không thể tạo thanh toán ZaloPay. Vui lòng thử lại.');
    }

    public function callback(Request $request)
    {
        $key2 = env('ZALOPAY_KEY2', 'kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz');
        
        $postdata = file_get_contents('php://input');
        $postdatajson = json_decode($postdata, true);
        
        $mac = hash_hmac("sha256", $postdatajson["data"], $key2);
        
        $requestmac = $postdatajson["mac"];

        // Verify callback signature
        if (strcmp($mac, $requestmac) != 0) {
            Log::error('ZaloPay callback invalid signature', ['data' => $postdatajson]);
            return response()->json([
                "return_code" => -1,
                "return_message" => "mac not equal"
            ]);
        }

        // Payment success
        $datajson = json_decode($postdatajson["data"], true);
        
        // Extract order number from app_trans_id or description
        $app_trans_id = $datajson["app_trans_id"];
        $description = $datajson["description"];
        $amount = $datajson["amount"];
        
        // Find order - we need to search by the transaction ID stored in notes
        // Escape wildcards to prevent SQL injection
        $escapedTransId = str_replace(['%', '_'], ['\\%', '\\_'], $app_trans_id);
        $order = Order::where('notes', 'like', '%' . $escapedTransId . '%')->first();
        
        if ($order) {
            // Validate amount matches order total
            if ($order->total != $amount) {
                Log::error('ZaloPay amount mismatch', [
                    'order_number' => $order->order_number,
                    'order_amount' => $order->total,
                    'zalopay_amount' => $amount
                ]);
                return response()->json([
                    "return_code" => -1,
                    "return_message" => "amount mismatch"
                ]);
            }

            // Check if already paid (prevent duplicate processing)
            if ($order->payment_status === 'paid') {
                Log::warning('ZaloPay duplicate callback attempt', [
                    'order_number' => $order->order_number,
                    'app_trans_id' => $app_trans_id
                ]);
                return response()->json([
                    "return_code" => 1,
                    "return_message" => "already processed"
                ]);
            }

            $order->update([
                'payment_status' => 'paid',
                'transaction_id' => $app_trans_id,
                'paid_at' => now(),
            ]);
            
            // Send email to admin
            $this->sendAdminNotification($order);
            
            Log::info('ZaloPay callback processed successfully', [
                'order_number' => $order->order_number,
                'app_trans_id' => $app_trans_id
            ]);
        } else {
            Log::error('ZaloPay callback - Order not found', [
                'app_trans_id' => $app_trans_id,
                'description' => $description
            ]);
        }

        return response()->json([
            "return_code" => 1,
            "return_message" => "success"
        ]);
    }

    public function return(Request $request)
    {
        $status = $request->status;
        $apptransid = $request->apptransid;
        
        // Find order by app_trans_id in notes (with SQL injection prevention)
        $escapedTransId = str_replace(['%', '_'], ['\\%', '\\_'], $apptransid);
        $order = Order::where('notes', 'like', '%' . $escapedTransId . '%')->first();
        
        if (!$order) {
            return redirect('/')->with('error', 'Không tìm thấy đơn hàng');
        }
        
        if ($status == 1) {
            // Payment success (already updated via callback)
            // Store order info in session for confirmation page
            session()->put('order_confirmation', [
                'order' => $order,
                'payment_method_name' => 'Ví ZaloPay',
                'payment_method' => 'zalopay',
                'online_method' => 'zalopay',
                'transaction_id' => $apptransid,
            ]);
            
            return redirect('/order-confirmation')->with('success', 'Thanh toán thành công!');
        } else {
            // Payment failed or cancelled
            $order->update([
                'payment_status' => 'pending',
                'notes' => ($order->notes ? $order->notes . "\n" : '') . 'ZaloPay payment failed or cancelled. Status: ' . $status,
            ]);
            
            return redirect('/checkout')->with('error', 'Thanh toán thất bại hoặc đã bị hủy.');
        }
    }

    public function queryOrder(Request $request)
    {
        // Query order status from ZaloPay
        $config = [
            "app_id" => env('ZALOPAY_APP_ID', '2553'),
            "key1" => env('ZALOPAY_KEY1', 'PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL'),
            "key2" => env('ZALOPAY_KEY2', 'kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz'),
            "endpoint" => "https://sb-openapi.zalopay.vn/v2/query"
        ];

        $app_trans_id = $request->app_trans_id;
        
        $data = $config["app_id"] . "|" . $app_trans_id . "|" . $config["key1"];
        $params = [
            "app_id" => $config["app_id"],
            "app_trans_id" => $app_trans_id,
            "mac" => hash_hmac("sha256", $data, $config["key1"])
        ];

        $context = stream_context_create([
            "http" => [
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => http_build_query($params)
            ]
        ]);

        $resp = file_get_contents($config["endpoint"], false, $context);
        $result = json_decode($resp, true);

        return response()->json($result);
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
}
