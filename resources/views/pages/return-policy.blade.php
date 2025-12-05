@extends('layouts.master')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chính sách đổi trả</li>
        </ol>
    </nav>

    <!-- Page Title -->
    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: #936f03;">
            <i class="bi bi-arrow-repeat me-2"></i>Chính Sách Kiểm Hàng & Đổi Trả
        </h1>
        <p class="text-muted">Quy định về bảo hành, đổi trả sản phẩm</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="alert alert-success border-0 mb-4">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-shield-check me-2"></i>Cam kết của {{ config('shop.name') }}
                        </h5>
                        <p class="mb-0">
                            {{ config('shop.name') }} cam kết mang đến cho Quý khách hàng những sản phẩm yến sào 
                            có chất lượng tốt nhất, giá trị cao nhất. Mỗi sản phẩm khi xuất kho đều được 
                            trải qua quá trình kiểm tra chặt chẽ, đạt các tiêu chuẩn nghiêm ngặt về 
                            vệ sinh an toàn thực phẩm.
                        </p>
                    </div>

                    <!-- Kiểm hàng khi nhận -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #936f03;">
                            <i class="bi bi-box-seam me-2"></i>1. Kiểm tra hàng khi nhận
                        </h3>
                        <div class="ms-4">
                            <div class="alert alert-warning border-0">
                                <h5 class="fw-bold mb-3">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Quan trọng:
                                </h5>
                                <p>
                                    Trong quá trình vận chuyển, hàng hóa có thể bị lỗi về hình thức 
                                    (trầy xước, biến dạng, chuyển màu sắc). Vì vậy khi nhận hàng từ 
                                    nhân viên giao hàng, Quý khách <strong>VUI LÒNG KIỂM TRA SẢN PHẨM 
                                    KỸ TRƯỚC KHI KÝ NHẬN</strong>.
                                </p>
                            </div>

                            <h5 class="fw-bold mt-4 mb-3">Các bước kiểm tra:</h5>
                            <ul>
                                <li><strong>Bước 1:</strong> Kiểm tra bên ngoài bao bì, hộp đựng có bị móp méo, rách hay không</li>
                                <li><strong>Bước 2:</strong> Mở hộp kiểm tra sản phẩm có đúng với đơn hàng đã đặt không</li>
                                <li><strong>Bước 3:</strong> Kiểm tra tình trạng sản phẩm (nguyên vẹn, không bể vỡ, tem niêm phong còn nguyên)</li>
                                <li><strong>Bước 4:</strong> Kiểm tra số lượng, quà tặng kèm theo (nếu có)</li>
                                <li><strong>Bước 5:</strong> Ký nhận và thanh toán nếu mọi thứ đều ổn</li>
                            </ul>

                            <div class="alert alert-danger border-0 mt-3">
                                <p class="mb-0">
                                    <i class="bi bi-x-circle-fill me-2"></i>
                                    <strong>Không ký nhận</strong> nếu phát hiện sản phẩm có vấn đề. 
                                    Liên hệ ngay Hotline <strong>{{ config('shop.phone') }}</strong> để được hỗ trợ.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Chính sách đổi trả -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #936f03;">
                            <i class="bi bi-arrow-left-right me-2"></i>2. Chính sách đổi trả
                        </h3>
                        
                        <div class="ms-4">
                            <h5 class="fw-bold mb-3">Điều kiện đổi trả:</h5>
                            
                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-2">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        Được chấp nhận đổi trả trong các trường hợp:
                                    </h6>
                                    <ul class="mb-0">
                                        <li>Sản phẩm bị lỗi do nhà sản xuất</li>
                                        <li>Sản phẩm bị bể vỡ, hư hỏng trong quá trình vận chuyển</li>
                                        <li>Giao nhầm sản phẩm, sai số lượng</li>
                                        <li>Sản phẩm thiếu phụ kiện, quà tặng kèm theo</li>
                                        <li>Sản phẩm không đúng mô tả</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-2">
                                        <i class="bi bi-x-circle-fill text-danger me-2"></i>
                                        Không chấp nhận đổi trả trong các trường hợp:
                                    </h6>
                                    <ul class="mb-0">
                                        <li>Sản phẩm đã qua sử dụng</li>
                                        <li>Sản phẩm đã bóc tem, mở niêm phong bảo hành</li>
                                        <li>Sản phẩm bị hư do thiên tai, hỏa hoạn, lụt lội, sét đánh</li>
                                        <li>Sản phẩm để nơi bụi bẩn, ẩm ướt, bị vào nước</li>
                                        <li>Sản phẩm bị biến dạng do tác động bên ngoài của khách hàng</li>
                                        <li>Sản phẩm đã được sửa chữa bởi bên thứ ba</li>
                                    </ul>
                                </div>
                            </div>

                            <h5 class="fw-bold mt-4 mb-3">Thời gian thông báo:</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Trường hợp</th>
                                            <th>Thời gian thông báo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Sản phẩm lỗi, không đúng mô tả</td>
                                            <td class="fw-bold text-danger">Trong vòng 48 giờ kể từ khi nhận hàng</td>
                                        </tr>
                                        <tr>
                                            <td>Sản phẩm bể vỡ, thiếu sản phẩm/phụ kiện</td>
                                            <td class="fw-bold text-danger">Trong vòng 24 giờ kể từ khi nhận hàng</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="fw-bold mt-4 mb-3">Quy trình đổi trả:</h5>
                            <ol>
                                <li>
                                    <strong>Liên hệ:</strong> Gọi Hotline 
                                    <a href="tel:{{ str_replace(' ', '', config('shop.phone')) }}" class="fw-bold">{{ config('shop.phone') }}</a> 
                                    hoặc email 
                                    <a href="mailto:{{ config('shop.email') }}">{{ config('shop.email') }}</a>
                                </li>
                                <li><strong>Cung cấp thông tin:</strong> Mã đơn hàng, ảnh sản phẩm lỗi, mô tả vấn đề</li>
                                <li><strong>Xác nhận:</strong> Nhân viên sẽ xác nhận và hướng dẫn cách thức đổi trả</li>
                                <li><strong>Gửi hàng:</strong> Đóng gói sản phẩm và gửi lại (trong vòng 7 ngày)</li>
                                <li><strong>Giải quyết:</strong> Nhận sản phẩm mới hoặc hoàn tiền (trong vòng 7-10 ngày)</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Chi phí đổi trả -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #936f03;">
                            <i class="bi bi-cash-coin me-2"></i>3. Chi phí đổi trả
                        </h3>
                        <div class="ms-4">
                            <ul>
                                <li><strong>Lỗi do nhà sản xuất hoặc vận chuyển:</strong> {{ config('shop.name') }} chịu toàn bộ chi phí</li>
                                <li><strong>Khách hàng đổi ý:</strong> Khách hàng chịu phí vận chuyển 2 chiều</li>
                                <li><strong>Đổi sang sản phẩm khác có giá cao hơn:</strong> Khách bù thêm phần chênh lệch</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Bảo hành -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #936f03;">
                            <i class="bi bi-tools me-2"></i>4. Chính sách bảo hành
                        </h3>
                        <div class="ms-4">
                            <p>
                                Các sản phẩm yến sào của {{ config('shop.name') }} được bảo hành về chất lượng 
                                sản phẩm theo quy định của nhà sản xuất.
                            </p>
                            <div class="alert alert-info border-0">
                                <p class="mb-0">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    Vui lòng giữ nguyên tem bảo hành và hóa đơn mua hàng để được hỗ trợ bảo hành tốt nhất.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Liên hệ -->
                    <div class="alert alert-primary border-0">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-headset me-2"></i>Liên hệ hỗ trợ
                        </h5>
                        <p>Trường hợp hàng hóa bị lỗi, Quý khách vui lòng liên hệ với Bộ phận Chăm sóc Khách hàng:</p>
                        <p class="mb-2">
                            <i class="bi bi-telephone-fill me-2"></i>
                            <strong>Hotline:</strong> 
                            <a href="tel:{{ str_replace(' ', '', config('shop.phone')) }}" class="text-decoration-none fw-bold">{{ config('shop.phone') }}</a>
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-envelope-fill me-2"></i>
                            <strong>Email:</strong> 
                            <a href="mailto:{{ config('shop.email') }}" class="text-decoration-none">{{ config('shop.email') }}</a>
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-clock-fill me-2"></i>
                            <strong>Thời gian hỗ trợ:</strong> 8:00 - 20:00 (Tất cả các ngày)
                        </p>
                    </div>

                    <!-- Cam kết -->
                    <div class="text-center mt-5 p-4 bg-light rounded">
                        <h4 class="fw-bold mb-3" style="color: #936f03;">
                            {{ config('shop.name') }}
                        </h4>
                        <p class="mb-0 fst-italic">
                            "Cam kết mang lại cho quý khách những sản phẩm chất lượng cao và trải nghiệm mua sắm tuyệt vời nhất"
                        </p>
                        <p class="mt-2 mb-0 text-muted">
                            <strong>Chúng tôi xin chân thành cảm ơn!</strong>
                        </p>
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
    
    .table {
        border-radius: 10px;
        overflow: hidden;
    }
</style>
@endsection
