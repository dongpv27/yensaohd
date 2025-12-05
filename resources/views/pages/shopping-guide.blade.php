@extends('layouts.master')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Hướng dẫn mua hàng</li>
        </ol>
    </nav>

    <!-- Page Title -->
    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: #936f03;">
            <i class="bi bi-cart-check me-2"></i>Hướng Dẫn Mua Hàng
        </h1>
        <p class="text-muted">Quy trình mua hàng đơn giản và nhanh chóng tại {{ config('shop.name') }}</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    
                    <p class="lead mb-4">
                        Để mua các sản phẩm yến sào chất lượng cao tại {{ config('shop.name') }}, 
                        quý khách hàng có thể lựa chọn một trong các cách sau:
                    </p>

                    <!-- Cách 1 -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #936f03;">
                            <span class="badge bg-warning text-dark me-2">1</span>
                            Mua hàng trực tiếp tại cửa hàng
                        </h3>
                        <div class="ms-4">
                            <p>
                                Quý khách có thể đến trực tiếp cửa hàng của chúng tôi để xem và mua sản phẩm:
                            </p>
                            <div class="alert alert-info">
                                <i class="bi bi-geo-alt-fill me-2"></i>
                                <strong>Địa chỉ:</strong> {{ config('shop.address') }}
                            </div>
                            <p class="text-muted fst-italic">
                                <i class="bi bi-clock me-2"></i>Giờ làm việc: 8:00 - 20:00 (Tất cả các ngày trong tuần)
                            </p>
                        </div>
                    </div>

                    <!-- Cách 2 -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #936f03;">
                            <span class="badge bg-warning text-dark me-2">2</span>
                            Đặt hàng qua Hotline
                        </h3>
                        <div class="ms-4">
                            <p>
                                Quý khách vui lòng liên hệ số Hotline của chúng tôi. Nhân viên tư vấn sẵn sàng 
                                hỗ trợ quý khách chọn sản phẩm yến sào phù hợp nhất.
                            </p>
                            <div class="alert alert-success">
                                <i class="bi bi-telephone-fill me-2"></i>
                                <strong>Hotline:</strong> <a href="tel:{{ str_replace(' ', '', config('shop.phone')) }}" class="text-decoration-none fw-bold">{{ config('shop.phone') }}</a>
                            </div>
                            <ul class="text-muted">
                                <li>Tư vấn miễn phí về sản phẩm</li>
                                <li>Hỗ trợ đặt hàng nhanh chóng</li>
                                <li>Giải đáp mọi thắc mắc</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Cách 3 -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #936f03;">
                            <span class="badge bg-warning text-dark me-2">3</span>
                            Đặt mua hàng Online trên Website
                        </h3>
                        <div class="ms-4">
                            <p>
                                Quý khách có thể mua sản phẩm yến sào chính hãng trực tuyến ngay trên website của chúng tôi.
                            </p>
                            
                            <h5 class="fw-bold mt-4 mb-3">Các bước đặt hàng:</h5>
                            
                            <!-- Bước 1 -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary">
                                    <i class="bi bi-1-circle-fill me-2"></i>Bước 1: Tìm kiếm sản phẩm
                                </h6>
                                <ul>
                                    <li>Truy cập vào trang web: <a href="{{ url('/') }}" class="fw-bold">{{ url('/') }}</a></li>
                                    <li>Sử dụng ô tìm kiếm hoặc danh mục sản phẩm để tìm sản phẩm mong muốn</li>
                                    <li>Tham khảo các sản phẩm bán chạy, sản phẩm khuyến mãi</li>
                                </ul>
                            </div>

                            <!-- Bước 2 -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary">
                                    <i class="bi bi-2-circle-fill me-2"></i>Bước 2: Thêm sản phẩm vào giỏ hàng
                                </h6>
                                <ul>
                                    <li>Click vào sản phẩm để xem thông tin chi tiết</li>
                                    <li>Chọn số lượng phù hợp</li>
                                    <li>Nhấn nút "Thêm vào giỏ hàng"</li>
                                    <li>Tiếp tục mua sắm hoặc chuyển đến giỏ hàng để thanh toán</li>
                                </ul>
                            </div>

                            <!-- Bước 3 -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary">
                                    <i class="bi bi-3-circle-fill me-2"></i>Bước 3: Tiến hành thanh toán
                                </h6>
                                <ul>
                                    <li>Vào giỏ hàng và kiểm tra lại đơn hàng</li>
                                    <li>Điền đầy đủ thông tin giao hàng (Họ tên, SĐT, Địa chỉ)</li>
                                    <li>Chọn phương thức thanh toán phù hợp</li>
                                    <li>Nhấn "Đặt hàng" để hoàn tất</li>
                                </ul>
                            </div>

                            <!-- Bước 4 -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary">
                                    <i class="bi bi-4-circle-fill me-2"></i>Bước 4: Xác nhận đơn hàng
                                </h6>
                                <ul>
                                    <li>Nhân viên của {{ config('shop.name') }} sẽ liên hệ lại để xác nhận đơn hàng</li>
                                    <li>Đơn hàng sẽ được đóng gói và giao đến địa chỉ của quý khách</li>
                                    <li>Quý khách có thể theo dõi tình trạng đơn hàng qua email hoặc điện thoại</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Lưu ý -->
                    <div class="alert alert-warning border-0">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>Lưu ý khi đặt hàng online:
                        </h5>
                        <ul class="mb-0">
                            <li>{{ config('shop.name') }} chỉ chấp nhận đơn hàng có thông tin chính xác về địa chỉ, số điện thoại</li>
                            <li>Giao hàng trong giờ hành chính, có thông báo trước nếu giao trễ</li>
                            <li>Hoàn tiền 100% trong vòng 7 ngày nếu không nhận được hàng</li>
                            <li>Sản phẩm cam kết yến nguyên chất 100%, mới hoàn toàn, có hóa đơn đầy đủ</li>
                            <li>Vui lòng kiểm tra kỹ sản phẩm trước khi ký nhận với nhân viên giao hàng</li>
                            <li>Chúng tôi không chịu trách nhiệm về hình thức hàng hóa sau khi quý khách đã ký nhận</li>
                        </ul>
                    </div>

                    <!-- Call to action -->
                    <div class="text-center mt-5">
                        <h4 class="fw-bold mb-3">Sẵn sàng mua sắm?</h4>
                        <a href="/products" class="btn btn-lg px-5" style="background: #936f03; color: white;">
                            <i class="bi bi-cart-plus me-2"></i>Mua hàng ngay
                        </a>
                    </div>

                    <!-- Contact -->
                    <div class="mt-5 pt-4 border-top">
                        <h5 class="fw-bold mb-3">Cần hỗ trợ?</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <i class="bi bi-telephone-fill text-success me-2"></i>
                                <strong>Hotline:</strong><br>
                                <a href="tel:{{ str_replace(' ', '', config('shop.phone')) }}" class="text-decoration-none">{{ config('shop.phone') }}</a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="bi bi-envelope-fill text-primary me-2"></i>
                                <strong>Email:</strong><br>
                                <a href="mailto:{{ config('shop.email') }}" class="text-decoration-none">{{ config('shop.email') }}</a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                                <strong>Địa chỉ:</strong><br>
                                {{ config('shop.address') }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 15px;
    }
    
    .alert {
        border-radius: 10px;
    }
    
    h3 .badge {
        font-size: 1.2rem;
    }
</style>
@endsection
