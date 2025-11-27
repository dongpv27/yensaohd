<footer class="brand-light text-dark py-5">
    <div class="container">
        <div class="row">
            <!-- Column 1: Logo centered + Brand Name -->
            <div class="col-md-4 mb-4 d-flex flex-column align-items-center justify-content-center">
                <img src="{{ asset('images/banners/logo.png') }}" alt="Logo" width="150" height="150">
                <h2 class="fw-bold mb-3" style="color:#936f03">{{ config('shop.name') }}</h2>
            </div>
            
            <!-- Column 2: Contact Info -->
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold mb-3">Thông Tin Liên Hệ</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i>Email: {{ config('shop.email') }}</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2"></i>SĐT: {{ config('shop.phone') }}</li>
                    <li class="mb-0"><i class="bi bi-geo-alt me-2"></i>Địa chỉ: {{ config('shop.address') }}</li>
                </ul>
            </div>
            
            <!-- Column 3: Policies -->
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold mb-3">Chính Sách</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#"><i class="bi bi-chevron-right me-1"></i>Hướng dẫn mua hàng</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right me-1"></i>Chính sách vận chuyển</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right me-1"></i>Chính sách kiểm hàng & đổi trả hàng</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right me-1"></i>Chính sách bảo mật</a></li>
                </ul>
            </div>
            
            <!-- Column 4: Popular Products -->
            <div class="col-md-2 mb-4">
                <h6 class="fw-bold mb-3">Sản Phẩm Phổ Biến</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="/products?category=Yến+Thô"><i class="bi bi-chevron-right me-1"></i>Yến Sào Thô</a></li>
                    <li><a href="/products?category=Yến+Tinh+Chế"><i class="bi bi-chevron-right me-1"></i>Yến Sào Tinh Chế</a></li>
                    <li><a href="/products?category=Yến+Chưng+Sẵn"><i class="bi bi-chevron-right me-1"></i>Yến Chưng Sẵn</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-4">
        <div class="text-center" style="color:#5A381E">© 2025 {{ config('shop.name') }}. All rights reserved.</div>
    </div>
</footer>

<!-- Floating Contact Buttons -->
<div class="floating-contact">
    <a href="{{ config('shop.social.facebook') }}" target="_blank" class="floating-btn fb-btn" title="Facebook">
        <i class="bi bi-facebook"></i>
    </a>
    <a href="{{ config('shop.social.zalo') }}" target="_blank" class="floating-btn zalo-btn" title="Zalo">
        <img src="https://page.widget.zalo.me/static/images/2.0/Logo.svg" alt="Zalo" width="24" height="24">
    </a>
    <a href="tel:{{ str_replace(' ', '', config('shop.phone')) }}" class="floating-btn phone-btn" title="Hotline">
        <i class="bi bi-telephone-fill"></i>
    </a>
</div>

<!-- Back to Top Button -->
<button id="backToTop" class="back-to-top" title="Về đầu trang">
    <i class="bi bi-arrow-up"></i>
</button>

