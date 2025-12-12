# Tóm tắt tích hợp thanh toán

## Các thay đổi đã thực hiện

### 1. Controllers mới
- ✅ `app/Http/Controllers/MoMoController.php` - Xử lý thanh toán MoMo
- ✅ `app/Http/Controllers/ZaloPayController.php` - Xử lý thanh toán ZaloPay

### 2. Routes mới
Đã thêm vào `routes/web.php`:
```php
// MoMo payment routes
Route::get('/momo/return', [MoMoController::class, 'return'])->name('momo.return');
Route::post('/momo/ipn', [MoMoController::class, 'ipn'])->name('momo.ipn');

// ZaloPay payment routes
Route::get('/zalopay/return', [ZaloPayController::class, 'return'])->name('zalopay.return');
Route::post('/zalopay/callback', [ZaloPayController::class, 'callback'])->name('zalopay.callback');
Route::post('/zalopay/query', [ZaloPayController::class, 'queryOrder'])->name('zalopay.query');
```

### 3. Cập nhật CartController
- Validation cho `online_method` đã được cập nhật: `vnpay`, `momo`, `zalopay`
- Logic xử lý thanh toán cho cả 3 phương thức

### 4. Cập nhật giao diện checkout
File `resources/views/cart/checkout.blade.php` đã được cập nhật với 3 tùy chọn thanh toán trực tuyến:
- ✅ VNPay
- ✅ MoMo
- ✅ ZaloPay

### 5. Documentation
- ✅ `MOMO_INTEGRATION.md` - Hướng dẫn tích hợp MoMo
- ✅ `ZALOPAY_INTEGRATION.md` - Hướng dẫn tích hợp ZaloPay
- ✅ `VNPAY_INTEGRATION.md` - Hướng dẫn tích hợp VNPay (đã có sẵn)

## Các bước tiếp theo

### 1. Cấu hình file .env

Thêm các biến môi trường sau vào file `.env`:

```env
# MoMo Payment Gateway
MOMO_PARTNER_CODE=DEMO
MOMO_ACCESS_KEY=DEMO
MOMO_SECRET_KEY=DEMO

# ZaloPay Payment Gateway
ZALOPAY_APP_ID=2553
ZALOPAY_KEY1=PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL
ZALOPAY_KEY2=kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz

# VNPay Payment Gateway (đã có)
VNPAY_TMN_CODE=DEMO
VNPAY_HASH_SECRET=DEMO

# Admin email
ADMIN_EMAIL=admin@yensaohd.vn
```

**Lưu ý:** Các giá trị trên là dùng cho môi trường test. Xem file integration docs để lấy thông tin test chính xác.

### 2. Cập nhật CSRF Exception

Thêm vào file `app/Http/Middleware/VerifyCsrfToken.php`:

```php
protected $except = [
    'momo/ipn',
    'zalopay/callback',
];
```

### 3. Tạo email template (nếu chưa có)

Tạo file `resources/views/emails/order-paid.blade.php` để gửi email thông báo cho admin khi có đơn hàng thanh toán thành công.

```blade
<!DOCTYPE html>
<html>
<head>
    <title>Đơn hàng mới</title>
</head>
<body>
    <h2>Đơn hàng mới đã thanh toán</h2>
    <p>Mã đơn hàng: #{{ $order->order_number }}</p>
    <p>Tổng tiền: {{ number_format($order->total, 0, ',', '.') }}₫</p>
    <p>Phương thức thanh toán: {{ $order->payment_method }}</p>
    <p>Trạng thái: {{ $order->payment_status }}</p>
</body>
</html>
```

### 4. Test thanh toán

#### Test MoMo:
1. Chạy: `ngrok http 8000` (nếu test trên localhost)
2. Cập nhật `MOMO_*` trong `.env` với thông tin test
3. Thực hiện checkout với phương thức MoMo
4. Xem chi tiết trong `MOMO_INTEGRATION.md`

#### Test ZaloPay:
1. Chạy: `ngrok http 8000` (nếu test trên localhost)
2. Sử dụng thông tin test trong `.env`
3. Thực hiện checkout với phương thức ZaloPay
4. Xem chi tiết trong `ZALOPAY_INTEGRATION.md`

### 5. Kiểm tra logs

```bash
# Xem logs Laravel
tail -f storage/logs/laravel.log

# Lọc theo payment gateway
tail -f storage/logs/laravel.log | grep "MoMo\|ZaloPay\|VNPay"
```

## Tính năng đã có

✅ Checkout form với 3 phương thức thanh toán trực tuyến
✅ Xử lý thanh toán VNPay
✅ Xử lý thanh toán MoMo (với IPN)
✅ Xử lý thanh toán ZaloPay (với callback)
✅ Redirect về trang xác nhận đơn hàng
✅ Gửi email thông báo cho admin khi thanh toán thành công
✅ Cập nhật trạng thái đơn hàng tự động
✅ Xác thực chữ ký từ các payment gateway

## Cấu trúc thanh toán

```
User chọn thanh toán
        ↓
CartController::processCheckout
        ↓
    [COD]  [Online]
      ↓         ↓
   Confirm  Gateway Controller (VNPay/MoMo/ZaloPay)
      ↓         ↓
      └─→ Redirect to Payment Gateway
                ↓
          User thanh toán
                ↓
         [Callback/IPN] ← Cập nhật order
                ↓
          Return URL
                ↓
      Order Confirmation Page
```

## Debug tips

### 1. Payment không redirect
- Kiểm tra logs: `storage/logs/laravel.log`
- Kiểm tra config `.env`
- Kiểm tra credentials

### 2. Callback không nhận được
- Đảm bảo route không bị CSRF token chặn
- Dùng ngrok cho localhost
- Kiểm tra URL callback đúng

### 3. Chữ ký không hợp lệ
- Kiểm tra Secret Key/Hash Secret
- Kiểm tra thứ tự tham số trong signature
- Kiểm tra encoding (UTF-8)

## Môi trường Production

Khi deploy lên production:

1. **Đăng ký tài khoản thật:**
   - MoMo Business: https://business.momo.vn/
   - ZaloPay Business: https://zalopay.vn/doanh-nghiep/
   - VNPay: https://vnpay.vn/

2. **Cập nhật credentials trong `.env`**

3. **Thay đổi endpoints sang production:**
   - MoMo: `https://payment.momo.vn/v2/gateway/api/create`
   - ZaloPay: `https://openapi.zalopay.vn/v2/create`
   - VNPay: `https://vnpayment.vn/paymentv2/vpcpay.html`

4. **Cấu hình callback URLs trong portal của từng gateway**

5. **Test kỹ với số tiền nhỏ trước khi đưa vào sử dụng chính thức**

## Tài liệu chi tiết

Xem các file sau để biết thêm chi tiết:
- `MOMO_INTEGRATION.md` - Chi tiết về MoMo
- `ZALOPAY_INTEGRATION.md` - Chi tiết về ZaloPay
- `VNPAY_INTEGRATION.md` - Chi tiết về VNPay

## Hỗ trợ

Nếu có vấn đề, liên hệ:
- MoMo: developer@momo.vn
- ZaloPay: developer@zalopay.vn
- VNPay: hotro@vnpay.vn
