# Tích hợp thanh toán ZaloPay

Hướng dẫn tích hợp cổng thanh toán ZaloPay vào website Laravel.

## Tổng quan

ZaloPay là ví điện tử thuộc hệ sinh thái Zalo, một trong những nền tảng thanh toán phổ biến tại Việt Nam với hơn 10 triệu người dùng.

## Yêu cầu

- PHP >= 8.0
- Laravel >= 10.x
- Extension cURL được bật
- Tài khoản ZaloPay Business

## Đăng ký tài khoản

1. Truy cập [ZaloPay for Business](https://zalopay.vn/doanh-nghiep/)
2. Đăng ký tài khoản doanh nghiệp
3. Hoàn tất xác minh thông tin doanh nghiệp
4. Sau khi được duyệt, bạn sẽ nhận được:
   - **App ID**: Mã ứng dụng
   - **Key 1**: Khóa bí mật 1 (dùng cho tạo chữ ký)
   - **Key 2**: Khóa bí mật 2 (dùng cho callback)

## Cấu hình môi trường

Thêm các biến sau vào file `.env`:

```env
# ZaloPay Payment Gateway Configuration
ZALOPAY_APP_ID=your_app_id
ZALOPAY_KEY1=your_key1
ZALOPAY_KEY2=your_key2

# Email nhận thông báo đơn hàng
ADMIN_EMAIL=admin@yensaohd.vn
```

### Môi trường Test (Sandbox)

Để test, sử dụng thông tin sau:

```env
ZALOPAY_APP_ID=2553
ZALOPAY_KEY1=PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL
ZALOPAY_KEY2=kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz
```

**Lưu ý:** Đây là thông tin demo public của ZaloPay, chỉ dùng cho môi trường test.

## Cấu trúc Controller

File `app/Http/Controllers/ZaloPayController.php` xử lý các tác vụ:

### 1. Tạo thanh toán (`createPayment`)

```php
public function createPayment(Order $order)
```

**Chức năng:**
- Tạo request thanh toán tới ZaloPay
- Tạo chữ ký HMAC SHA256
- Redirect khách hàng tới trang thanh toán ZaloPay

**Thông số quan trọng:**
- `app_trans_id`: Mã giao dịch duy nhất (format: `yymmdd_timestamp`)
- `app_time`: Thời gian tạo đơn (milliseconds)
- `amount`: Số tiền (VND)
- `embed_data`: Dữ liệu nhúng (JSON), chứa redirect URL
- `callback_url`: URL nhận thông báo callback
- `mac`: Chữ ký HMAC SHA256

**Format app_trans_id:**
```php
$app_trans_id = date("ymd") . "_" . time();
// Ví dụ: 231201_1638360000
```

### 2. Xử lý callback (`callback`)

```php
public function callback(Request $request)
```

**Chức năng:**
- Nhận thông báo thanh toán từ ZaloPay server
- Xác thực chữ ký MAC
- Cập nhật trạng thái đơn hàng
- Trả về JSON response

**Quan trọng:**
- Callback được gọi từ server ZaloPay, không qua browser
- Phải xử lý và trả về nhanh (< 1 giây)
- Nếu không trả về `return_code: 1`, ZaloPay sẽ retry

**Response format:**
```json
{
    "return_code": 1,
    "return_message": "success"
}
```

### 3. Xử lý return URL (`return`)

```php
public function return(Request $request)
```

**Chức năng:**
- Nhận user quay về sau khi thanh toán
- Kiểm tra status thanh toán
- Redirect tới trang confirmation

**Status codes:**
- `1`: Thanh toán thành công
- `-1`: Thanh toán thất bại
- `2`: Giao dịch chờ xử lý

### 4. Query trạng thái giao dịch (`queryOrder`)

```php
public function queryOrder(Request $request)
```

**Chức năng:**
- Kiểm tra trạng thái thanh toán từ ZaloPay
- Dùng để đồng bộ trạng thái nếu callback bị mất

## Routes

Thêm vào `routes/web.php`:

```php
use App\Http\Controllers\ZaloPayController;

// ZaloPay payment routes
Route::get('/zalopay/return', [ZaloPayController::class, 'return'])->name('zalopay.return');
Route::post('/zalopay/callback', [ZaloPayController::class, 'callback'])->name('zalopay.callback');
Route::post('/zalopay/query', [ZaloPayController::class, 'queryOrder'])->name('zalopay.query');
```

## Middleware CSRF Exception

Thêm route callback vào danh sách ngoại lệ CSRF trong `app/Http/Middleware/VerifyCsrfToken.php`:

```php
protected $except = [
    'zalopay/callback',
];
```

## Luồng thanh toán

```
1. Khách hàng chọn ZaloPay → Submit form checkout
                ↓
2. CartController → Tạo Order → ZaloPayController::createPayment()
                ↓
3. Lưu app_trans_id vào order notes
                ↓
4. Redirect khách hàng tới ZaloPay Gateway
                ↓
5. Khách hàng quét QR hoặc mở ZaloPay app
                ↓
6. ZaloPay gửi callback tới /zalopay/callback (cập nhật order)
                ↓
7. ZaloPay redirect khách hàng về /zalopay/return
                ↓
8. Hiển thị trang Order Confirmation
```

## Đặc điểm quan trọng của ZaloPay

### 1. App Transaction ID

ZaloPay yêu cầu `app_trans_id` có format đặc biệt:

```php
$app_trans_id = date("ymd") . "_" . time();
```

**Quy tắc:**
- 6 ký tự đầu: `yymmdd` (năm, tháng, ngày)
- Dấu gạch dưới `_`
- Phần sau: số duy nhất (thường dùng timestamp)

### 2. App Time

Phải là milliseconds (không phải seconds):

```php
$app_time = round(microtime(true) * 1000);
```

### 3. Embed Data

Dữ liệu JSON chứa thông tin bổ sung:

```php
$embeddata = json_encode([
    'redirecturl' => route('zalopay.return'),
    'columninfo' => [], // Thông tin cột (nếu có)
    'promotioninfo' => [], // Thông tin khuyến mãi (nếu có)
]);
```

### 4. MAC Signature

Thứ tự tham số rất quan trọng:

```php
$data = $app_id . "|" . 
        $app_trans_id . "|" . 
        $app_user . "|" . 
        $amount . "|" . 
        $app_time . "|" . 
        $embed_data . "|" . 
        $item;

$mac = hash_hmac("sha256", $data, $key1);
```

## Test thanh toán

### Môi trường Sandbox

1. Endpoint: `https://sb-openapi.zalopay.vn/v2/create`
2. Query endpoint: `https://sb-openapi.zalopay.vn/v2/query`
3. Dùng thông tin test ở trên

### Công cụ test

- ZaloPay cung cấp [Postman Collection](https://docs.zalopay.vn/v2/)
- Test với app ZaloPay Sandbox (tải từ docs)

### Tài khoản test

Tạo tài khoản test trong app ZaloPay Sandbox:
- Không cần đăng ký thật
- Số dư test không giới hạn

## Xử lý lỗi thường gặp

### 1. Invalid MAC

**Nguyên nhân:**
- Key1/Key2 sai
- Thứ tự tham số trong MAC không đúng
- Encoding sai

**Giải pháp:**
```php
// Kiểm tra lại thứ tự theo đúng document
$data = $app_id . "|" . 
        $app_trans_id . "|" . 
        $app_user . "|" . 
        $amount . "|" . 
        $app_time . "|" . 
        $embed_data . "|" . 
        $item;

// Log để debug
Log::info('ZaloPay MAC data', ['data' => $data]);
```

### 2. Invalid app_trans_id format

**Nguyên nhân:**
- Format không đúng `yymmdd_xxxx`
- Trùng lặp app_trans_id

**Giải pháp:**
```php
// Đảm bảo format đúng
$app_trans_id = date("ymd") . "_" . time();
```

### 3. Callback không nhận được

**Nguyên nhân:**
- Callback URL không public
- Response chậm (> 1s)
- CSRF token chặn

**Giải pháp:**
- Dùng ngrok: `ngrok http 8000`
- Xử lý callback nhanh, trả về ngay
- Thêm vào CSRF exception

### 4. Order not found

**Nguyên nhân:**
- Không tìm thấy order từ app_trans_id

**Giải pháp:**
```php
// Lưu app_trans_id vào order khi tạo
$order->update([
    'notes' => 'ZaloPay Transaction ID: ' . $app_trans_id
]);

// Tìm order trong callback
$order = Order::where('notes', 'like', '%' . $app_trans_id . '%')->first();
```

## Bảo mật

### 1. Xác thực MAC trong callback

```php
$mac = hash_hmac("sha256", $postdatajson["data"], $key2);

if (strcmp($mac, $requestmac) != 0) {
    return response()->json([
        "return_code" => -1,
        "return_message" => "mac not equal"
    ]);
}
```

### 2. Kiểm tra số tiền

```php
$datajson = json_decode($postdatajson["data"], true);
$amount = $datajson["amount"];

if ($order->total != $amount) {
    Log::error('ZaloPay amount mismatch');
    return;
}
```

### 3. Tránh duplicate processing

```php
if ($order->payment_status === 'paid') {
    return response()->json([
        "return_code" => 1,
        "return_message" => "already processed"
    ]);
}
```

## Query Order Status

Dùng để kiểm tra trạng thái đơn hàng:

```php
POST https://sb-openapi.zalopay.vn/v2/query
Content-Type: application/x-www-form-urlencoded

app_id=2553&app_trans_id=231201_1638360000&mac=...
```

**Response:**
```json
{
    "return_code": 1,
    "return_message": "Giao dịch thành công",
    "sub_return_code": 1,
    "sub_return_message": "",
    "is_processing": false,
    "amount": 50000,
    "zp_trans_id": "231201000000123"
}
```

**Return codes:**
- `1`: Thanh toán thành công
- `2`: Thanh toán thất bại
- `3`: Giao dịch đang xử lý

## Môi trường Production

Khi chuyển sang production:

1. Đăng ký tài khoản ZaloPay Business chính thức
2. Cập nhật thông tin trong `.env`:
   ```env
   ZALOPAY_APP_ID=your_production_app_id
   ZALOPAY_KEY1=your_production_key1
   ZALOPAY_KEY2=your_production_key2
   ```
3. Thay đổi endpoint:
   ```php
   "endpoint" => "https://openapi.zalopay.vn/v2/create"
   ```
4. Cấu hình Callback URL trong ZaloPay Business Portal
5. Whitelist IP của server (nếu cần)
6. Test kỹ với số tiền nhỏ

## Logs và Debug

### Bật logging

```php
Log::info('ZaloPay payment created', [
    'order_number' => $order->order_number,
    'app_trans_id' => $app_trans_id,
    'amount' => $amount
]);

Log::error('ZaloPay payment failed', [
    'order_number' => $order->order_number,
    'error' => $error
]);
```

### Kiểm tra logs

```bash
tail -f storage/logs/laravel.log | grep ZaloPay
```

## API Reference

### Create Order Request

```
POST https://sb-openapi.zalopay.vn/v2/create
Content-Type: application/x-www-form-urlencoded

app_id=2553
&app_user=user123
&app_time=1638360000000
&amount=50000
&app_trans_id=231201_1638360000
&embed_data={"redirecturl":"https://domain.com/zalopay/return"}
&item=[]
&description=Thanh toán đơn hàng
&bank_code=
&mac=...
```

### Response

```json
{
    "return_code": 1,
    "return_message": "success",
    "sub_return_code": 1,
    "sub_return_message": "success",
    "order_url": "https://sbgateway.zalopay.vn/openapi/pay/...",
    "zp_trans_token": "...",
    "order_token": "...",
    "qr_code": "..."
}
```

### Callback Data Format

```json
{
    "data": "{\"app_id\":2553,\"app_trans_id\":\"231201_1638360000\",\"amount\":50000,\"app_user\":\"user123\",\"app_time\":1638360000000,\"embed_data\":\"{}\",\"item\":\"[]\",\"zp_trans_id\":231201000000123,\"server_time\":1638360000000,\"channel\":3,\"merchant_user_id\":\"merchant123\",\"user_fee_amount\":0,\"discount_amount\":0}",
    "mac": "..."
}
```

## Webhook Testing

Dùng ngrok để test callback:

```bash
# Chạy ngrok
ngrok http 8000

# Cập nhật callback URL trong code
$callback_url = "https://abc123.ngrok.io/zalopay/callback";
```

## So sánh với VNPay và MoMo

| Tính năng | ZaloPay | VNPay | MoMo |
|-----------|---------|-------|------|
| Phí giao dịch | 1.1% - 2.2% | 1.5% - 2.5% | 1.5% - 2.5% |
| Thời gian nhận tiền | T+1 | T+1 | T+1 |
| Callback | POST (JSON) | GET params | POST (JSON) |
| Signature | HMAC SHA256 | HMAC SHA512 | HMAC SHA256 |
| Transaction ID format | yymmdd_xxxx | Tự do | Tự do |
| App requirement | Có app | Không bắt buộc | Có app |

## Tài liệu tham khảo

- [ZaloPay Developer Portal](https://docs.zalopay.vn/)
- [API Documentation](https://docs.zalopay.vn/v2/)
- [Business Portal](https://zalopay.vn/doanh-nghiep/)
- [Sandbox Testing](https://sbgateway.zalopay.vn/)

## FAQ

### 1. ZaloPay có hỗ trợ thanh toán không cần app không?

Có, ZaloPay hỗ trợ thanh toán qua QR code mà không cần cài app. Khách hàng có thể quét QR bằng camera điện thoại.

### 2. Callback có được gọi nếu user không click "Quay về trang merchant"?

Có. Callback luôn được gọi khi thanh toán thành công, bất kể user có quay về hay không.

### 3. Làm sao để test callback trong localhost?

Dùng ngrok hoặc các công cụ tương tự để expose localhost ra internet.

### 4. app_trans_id có bắt buộc phải theo format yymmdd không?

Có. Đây là yêu cầu bắt buộc của ZaloPay để quản lý giao dịch theo ngày.

## Hỗ trợ

- Email: developer@zalopay.vn
- Hotline: 1900 5555 77
- Zalo OA: @zalopay

## License

MIT License - Tự do sử dụng cho dự án thương mại và phi thương mại.
