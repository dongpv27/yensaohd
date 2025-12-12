# Tích hợp thanh toán MoMo

Hướng dẫn tích hợp cổng thanh toán MoMo vào website Laravel.

## Tổng quan

MoMo là một trong những ví điện tử phổ biến nhất tại Việt Nam. Tích hợp MoMo cho phép khách hàng thanh toán trực tiếp qua ứng dụng MoMo.

## Yêu cầu

- PHP >= 8.0
- Laravel >= 10.x
- Extension cURL được bật
- Tài khoản MoMo Business

## Đăng ký tài khoản

1. Truy cập [MoMo Business Portal](https://business.momo.vn/)
2. Đăng ký tài khoản doanh nghiệp
3. Hoàn tất xác minh thông tin doanh nghiệp
4. Sau khi được duyệt, bạn sẽ nhận được:
   - **Partner Code**: Mã đối tác
   - **Access Key**: Khóa truy cập
   - **Secret Key**: Khóa bí mật

## Cấu hình môi trường

Thêm các biến sau vào file `.env`:

```env
# MoMo Payment Gateway Configuration
MOMO_PARTNER_CODE=your_partner_code
MOMO_ACCESS_KEY=your_access_key
MOMO_SECRET_KEY=your_secret_key

# Email nhận thông báo đơn hàng
ADMIN_EMAIL=admin@yensaohd.vn
```

### Môi trường Test (Sandbox)

Để test, sử dụng thông tin sau:

```env
MOMO_PARTNER_CODE=MOMO
MOMO_ACCESS_KEY=F8BBA842ECF85
MOMO_SECRET_KEY=K951B6PE1waDMi640xX08PD3vg6EkVlz
```

## Cấu trúc Controller

File `app/Http/Controllers/MoMoController.php` xử lý các tác vụ:

### 1. Tạo thanh toán (`createPayment`)

```php
public function createPayment(Order $order)
```

**Chức năng:**
- Tạo request thanh toán tới MoMo
- Tạo chữ ký HMAC SHA256 để bảo mật
- Redirect khách hàng tới trang thanh toán MoMo

**Thông số gửi đi:**
- `partnerCode`: Mã đối tác
- `orderId`: Mã đơn hàng
- `amount`: Số tiền (VND)
- `orderInfo`: Thông tin đơn hàng
- `redirectUrl`: URL trả về sau khi thanh toán
- `ipnUrl`: URL nhận thông báo từ MoMo
- `requestType`: Loại yêu cầu (captureWallet)
- `signature`: Chữ ký HMAC

### 2. Xử lý kết quả thanh toán (`return`)

```php
public function return(Request $request)
```

**Chức năng:**
- Nhận kết quả thanh toán từ MoMo
- Xác thực chữ ký
- Cập nhật trạng thái đơn hàng
- Gửi email thông báo cho admin
- Redirect tới trang xác nhận

**Mã kết quả (`resultCode`):**
- `0`: Thanh toán thành công
- `9000`: Giao dịch được xác nhận thành công
- `1006`: Giao dịch thất bại do user hủy
- `1001`: Giao dịch thất bại do user từ chối
- Các mã khác: Xem [tài liệu MoMo](https://developers.momo.vn/v3/vi/docs/payment/api/result-handling/resultcode/)

### 3. Xử lý IPN (`ipn`)

```php
public function ipn(Request $request)
```

**Chức năng:**
- Nhận thông báo thanh toán từ server MoMo (IPN - Instant Payment Notification)
- Xác thực chữ ký
- Cập nhật trạng thái thanh toán
- Trả về JSON response cho MoMo

**Quan trọng:** 
- IPN được gọi từ server MoMo, không qua browser
- Phải xử lý bất đồng bộ và trả về nhanh chóng
- Nếu không trả về kịp thời, MoMo sẽ thử lại nhiều lần

## Routes

Thêm vào `routes/web.php`:

```php
use App\Http\Controllers\MoMoController;

// MoMo payment routes
Route::get('/momo/return', [MoMoController::class, 'return'])->name('momo.return');
Route::post('/momo/ipn', [MoMoController::class, 'ipn'])->name('momo.ipn');
```

**Lưu ý:** Route `/momo/ipn` phải được cấu hình trong MoMo Business Portal và không được bảo vệ bởi CSRF token.

## Middleware CSRF Exception

Thêm route IPN vào danh sách ngoại lệ CSRF trong `app/Http/Middleware/VerifyCsrfToken.php`:

```php
protected $except = [
    'momo/ipn',
];
```

## Luồng thanh toán

```
1. Khách hàng chọn MoMo → Submit form checkout
                ↓
2. CartController → Tạo Order → MoMoController::createPayment()
                ↓
3. Redirect khách hàng tới MoMo Payment Gateway
                ↓
4. Khách hàng đăng nhập MoMo app và xác nhận thanh toán
                ↓
5. MoMo gửi IPN tới /momo/ipn (cập nhật order)
                ↓
6. MoMo redirect khách hàng về /momo/return
                ↓
7. Hiển thị trang Order Confirmation
```

## Test thanh toán

### Môi trường Sandbox

1. Sử dụng thông tin test ở trên
2. Endpoint: `https://test-payment.momo.vn/v2/gateway/api/create`
3. Tài khoản test MoMo:
   - Số điện thoại: 0123456789
   - OTP: 123456

### Công cụ test

- [MoMo Payment Gateway Documentation](https://developers.momo.vn/)
- [API Testing Tool](https://developers.momo.vn/v3/vi/docs/tools/test-tool/)

## Xử lý lỗi thường gặp

### 1. Chữ ký không hợp lệ

**Nguyên nhân:**
- Secret key sai
- Thứ tự tham số trong chuỗi signature không đúng
- Encoding không đúng (phải là UTF-8)

**Giải pháp:**
```php
// Đảm bảo thứ tự tham số đúng theo document
$rawHash = "accessKey=" . $accessKey . 
           "&amount=" . $amount . 
           "&extraData=" . $extraData . 
           // ... các tham số theo đúng thứ tự
```

### 2. IPN không nhận được

**Nguyên nhân:**
- IPN URL không public (localhost)
- Firewall chặn
- CSRF token chặn request

**Giải pháp:**
- Sử dụng ngrok để expose localhost: `ngrok http 8000`
- Thêm route vào CSRF exception
- Kiểm tra log server

### 3. Timeout

**Nguyên nhân:**
- Network chậm
- Xử lý IPN quá lâu

**Giải pháp:**
```php
// Trong IPN handler, xử lý nhanh và trả về
return response()->json(['message' => 'IPN processed']);
```

## Bảo mật

### 1. Xác thực chữ ký

Luôn xác thực signature từ MoMo:

```php
$checkSignature = hash_hmac("sha256", $rawHash, $secretKey);
if ($checkSignature != $signature) {
    Log::error('Invalid MoMo signature');
    return response()->json(['message' => 'Invalid signature'], 400);
}
```

### 2. Kiểm tra số tiền

```php
// Kiểm tra số tiền khớp với order
if ($order->total != $amount) {
    Log::error('Amount mismatch', [
        'order_amount' => $order->total,
        'momo_amount' => $amount
    ]);
    return;
}
```

### 3. Xử lý trạng thái đơn hàng

```php
// Không cập nhật nếu order đã được thanh toán
if ($order->payment_status === 'paid') {
    return; // Tránh duplicate processing
}
```

## Môi trường Production

Khi chuyển sang production:

1. Đăng ký tài khoản MoMo Business chính thức
2. Cập nhật thông tin trong `.env`:
   ```env
   MOMO_PARTNER_CODE=your_production_partner_code
   MOMO_ACCESS_KEY=your_production_access_key
   MOMO_SECRET_KEY=your_production_secret_key
   ```
3. Thay đổi endpoint thành production:
   ```php
   $endpoint = "https://payment.momo.vn/v2/gateway/api/create";
   ```
4. Cấu hình IPN URL và Return URL trong MoMo Business Portal
5. Test kỹ lưỡng với số tiền nhỏ trước

## Logs và Debug

### Bật logging

```php
Log::info('MoMo payment created', [
    'order_number' => $order->order_number,
    'amount' => $amount,
    'request_id' => $requestId
]);

Log::error('MoMo payment failed', [
    'order_number' => $order->order_number,
    'error' => $error,
    'response' => $response
]);
```

### Kiểm tra logs

```bash
tail -f storage/logs/laravel.log | grep MoMo
```

## API Reference

### Create Payment Request

```
POST https://test-payment.momo.vn/v2/gateway/api/create
Content-Type: application/json

{
    "partnerCode": "MOMO",
    "accessKey": "F8BBA842ECF85",
    "requestId": "1234567890",
    "amount": "50000",
    "orderId": "ORD-20231201-001",
    "orderInfo": "Thanh toán đơn hàng",
    "redirectUrl": "https://domain.com/momo/return",
    "ipnUrl": "https://domain.com/momo/ipn",
    "extraData": "",
    "requestType": "captureWallet",
    "signature": "..."
}
```

### Response

```json
{
    "partnerCode": "MOMO",
    "orderId": "ORD-20231201-001",
    "requestId": "1234567890",
    "amount": 50000,
    "responseTime": 1638360000000,
    "message": "Successful.",
    "resultCode": 0,
    "payUrl": "https://payment.momo.vn/pay/...",
    "deeplink": "momo://app.momo.vn/...",
    "qrCodeUrl": "https://payment.momo.vn/qr/..."
}
```

## Tài liệu tham khảo

- [MoMo Developer Portal](https://developers.momo.vn/)
- [API Documentation](https://developers.momo.vn/v3/vi/docs/payment/api/payment-api/onetime/)
- [Result Code](https://developers.momo.vn/v3/vi/docs/payment/api/result-handling/resultcode/)
- [Business Portal](https://business.momo.vn/)

## Hỗ trợ

- Email: developer@momo.vn
- Hotline: 1900 636 652

## License

MIT License - Tự do sử dụng cho dự án thương mại và phi thương mại.
