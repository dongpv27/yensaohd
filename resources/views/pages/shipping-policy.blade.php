@extends('layouts.master')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chính sách vận chuyển</li>
        </ol>
    </nav>

    <!-- Page Title -->
    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: #936f03;">
            <i class="bi bi-truck me-2"></i>Chính Sách Vận Chuyển
        </h1>
        <p class="text-muted">Thông tin về phương thức và chi phí vận chuyển</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    
                    <p class="lead mb-4">
                        Nhằm phục vụ quý khách hàng tốt hơn, {{ config('shop.name') }} xin thông tin đến 
                        Quý Khách Hàng các hình thức vận chuyển, chi phí và lưu ý được áp dụng 
                        tại website bán hàng trực tuyến như sau.
                    </p>

                    <!-- Đối tượng áp dụng -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #936f03;">
                            <i class="bi bi-people-fill me-2"></i>1. Đối tượng áp dụng
                        </h3>
                        <p class="ms-4">
                            Tất cả các khách hàng mua hàng trực tuyến tại website {{ url('/') }}
                        </p>
                    </div>

                    <!-- Nội dung chính sách -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #936f03;">
                            <i class="bi bi-file-text-fill me-2"></i>2. Nội dung chính sách vận chuyển
                        </h3>
                        
                        <!-- Phương thức giao hàng -->
                        <div class="ms-4 mb-4">
                            <h5 class="fw-bold mb-3">a) Giao hàng tận nơi:</h5>
                            <p>
                                Nhân viên giao nhận của {{ config('shop.name') }} sẽ thông báo tổng số tiền 
                                Quý khách cần thanh toán trước khi đến giao hàng.
                            </p>
                            <p>
                                Tổng giá trị đơn hàng bao gồm: <strong>Giá tiền sản phẩm + Cước phí giao hàng</strong>
                            </p>

                            <!-- Bảng phí vận chuyển -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Khu vực</th>
                                            <th>Điều kiện</th>
                                            <th>Phí vận chuyển</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="2"><strong>Nội thành TP.HCM</strong><br>(Bán kính dưới 10km)</td>
                                            <td>Tất cả đơn hàng</td>
                                            <td class="text-success fw-bold">Miễn phí vận chuyển</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-muted fst-italic">
                                                <small>Giao hàng trong vòng 4-6 giờ kể từ khi xác nhận đơn</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="3"><strong>Ngoại thành TP.HCM</strong><br>(Bán kính trên 10km, các huyện)</td>
                                            <td>Đơn hàng dưới 1.000.000đ</td>
                                            <td>30.000đ - 50.000đ</td>
                                        </tr>
                                        <tr>
                                            <td>Đơn hàng từ 1.000.000đ trở lên</td>
                                            <td class="text-success fw-bold">Miễn phí vận chuyển</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-muted fst-italic">
                                                <small>Thời gian giao: 1-2 ngày làm việc</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="3"><strong>Các tỉnh thành khác</strong></td>
                                            <td>Đơn hàng dưới 2.000.000đ</td>
                                            <td>Theo cước phí đối tác vận chuyển</td>
                                        </tr>
                                        <tr>
                                            <td>Đơn hàng từ 2.000.000đ trở lên</td>
                                            <td class="text-success fw-bold">Miễn phí vận chuyển</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-muted fst-italic">
                                                <small>Thời gian giao: 2-5 ngày làm việc</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Đối tác vận chuyển -->
                        <div class="ms-4 mb-4">
                            <h5 class="fw-bold mb-3">b) Đối tác vận chuyển:</h5>
                            <ul>
                                <li>Nội thành TP.HCM: Đội ngũ giao hàng của {{ config('shop.name') }}</li>
                                <li>Ngoại tỉnh: Liên kết với các đơn vị vận chuyển uy tín (Giao Hàng Nhanh, Giao Hàng Tiết Kiệm, Viettel Post, J&T Express)</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Lưu ý -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #936f03;">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>3. Lưu ý quan trọng
                        </h3>
                        <div class="alert alert-warning border-0">
                            <ul class="mb-0">
                                <li>Vui lòng kiểm tra kỹ sản phẩm trước khi ký nhận với nhân viên giao hàng</li>
                                <li>Không ký nhận nếu sản phẩm bị hư hỏng, bể vỡ hoặc không đúng với đơn hàng</li>
                                <li>Liên hệ ngay Hotline <strong>{{ config('shop.phone') }}</strong> nếu có vấn đề phát sinh</li>
                                <li>Trong một số chương trình khuyến mãi, chúng tôi có thể miễn phí hoặc giảm giá vận chuyển đặc biệt</li>
                                <li>Phí vận chuyển có thể thay đổi tùy theo khoảng cách và khối lượng đơn hàng</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Thông tin liên hệ -->
                    <div class="alert alert-info border-0">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-headset me-2"></i>Thông tin liên hệ
                        </h5>
                        <p class="mb-2">
                            <strong>Hotline:</strong> 
                            <a href="tel:{{ str_replace(' ', '', config('shop.phone')) }}" class="text-decoration-none fw-bold">{{ config('shop.phone') }}</a>
                        </p>
                        <p class="mb-2">
                            <strong>Email:</strong> 
                            <a href="mailto:{{ config('shop.email') }}" class="text-decoration-none">{{ config('shop.email') }}</a>
                        </p>
                        <p class="mb-0">
                            <strong>Địa chỉ:</strong> {{ config('shop.address') }}
                        </p>
                    </div>

                    <!-- Cam kết -->
                    <div class="text-center mt-5 p-4 bg-light rounded">
                        <h4 class="fw-bold mb-3" style="color: #936f03;">
                            {{ config('shop.name') }}
                        </h4>
                        <p class="mb-0 fst-italic">
                            "Cam kết mang đến cho quý khách những sản phẩm chất lượng và trải nghiệm mua sắm tuyệt vời nhất"
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
    
    .table thead {
        background: #936f03;
        color: white;
    }
</style>
@endsection
