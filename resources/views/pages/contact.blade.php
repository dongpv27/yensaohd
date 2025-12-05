@extends('layouts.master')

@section('content')
<div class="contact-page">
    <!-- Hero Section with Contact Info -->
    <section class="contact-hero py-5" style="background: linear-gradient(135deg, #575655 0%, #c49b33 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-white mb-4 mb-lg-0">
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ asset('images/banners/logo.png') }}" alt="{{ config('shop.name') }}" width="100" height="100" class="me-3">
                        <div style="text-align: center;">
                            <h1 class="fw-bold mb-2" style="font-size: 2.5rem;">{{ strtoupper(config('shop.name')) }}</h1>
                            <p class="mb-0" style="font-size: 1.1rem;">Chất lượng vàng - Sức khỏe bền vững</p>
                        </div>
                    </div>
                    <p class="lead mb-0">Chuyên cung cấp yến sào thiên nhiên cao cấp, uy tín và chất lượng hàng đầu tại Việt Nam</p>
                </div>
                <div class="col-lg-6">
                    <div class="contact-info-cards">
                        <div class="card border-0 shadow-sm mb-3" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-box me-3" style="width: 50px; height: 50px; background: #936f03; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-telephone-fill text-white fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 text-muted">Hotline</h6>
                                        <a href="tel:{{ str_replace(' ', '', config('shop.phone')) }}" class="text-dark fw-bold fs-5 text-decoration-none">{{ config('shop.phone') }}</a>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-box me-3" style="width: 50px; height: 50px; background: #0068FF; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-chat-dots-fill text-white fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 text-muted">Zalo</h6>
                                        <a href="{{ config('shop.social.zalo') }}" target="_blank" class="text-dark fw-bold fs-5 text-decoration-none">{{ config('shop.phone') }}</a>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-box me-3" style="width: 50px; height: 50px; background: #1877F2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-facebook text-white fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 text-muted">Facebook</h6>
                                        <a href="{{ config('shop.social.facebook') }}" target="_blank" class="text-dark fw-bold text-decoration-none">{{ config('shop.name') }}</a>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="icon-box me-3" style="width: 50px; height: 50px; background: #EA4335; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-envelope-fill text-white fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 text-muted">Email</h6>
                                        <a href="mailto:{{ config('shop.email') }}" class="text-dark fw-bold text-decoration-none">{{ config('shop.email') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Slider Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3" style="color: #936f03;">
                    <i class="bi bi-star-fill me-2"></i>SẢN PHẨM NỔI BẬT
                </h2>
                <p class="text-muted">Khám phá những sản phẩm yến sào cao cấp của chúng tôi</p>
            </div>

            <div id="productsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php
                        $featuredProducts = App\Models\Product::where('is_best_seller', true)
                            ->take(12)
                            ->get();
                        // Desktop: 4 products, Tablet: 3 products, Mobile: 2 products
                        $desktopChunks = $featuredProducts->chunk(4);
                        $tabletChunks = $featuredProducts->chunk(3);
                        $mobileChunks = $featuredProducts->chunk(2);
                    @endphp

                    {{-- Desktop slides --}}
                    @forelse($desktopChunks as $index => $chunk)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }} d-none d-lg-block">
                        <div class="row g-4">
                            @foreach($chunk as $product)
                            <div class="col-lg-3">
                                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; transition: transform 0.3s;">
                                    <div class="position-relative" style="height: 250px; overflow: hidden;">
                                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/products/product-1.jpg') }}" 
                                             class="card-img-top w-100 h-100" 
                                             style="object-fit: cover; cursor: pointer;"
                                             alt="{{ $product->name }}"
                                             onclick="window.location.href='{{ url('/products/' . $product->id) }}'">
                                        @if($product->is_best_seller)
                                        <span class="position-absolute top-0 start-0 m-3 badge bg-danger">-{{ $product->discount_percent }}%</span>
                                        @endif
                                        @if($product->weight)
                                        <span class="position-absolute bottom-0 end-0 m-3 badge bg-success">
                                            <i class="bi bi-box-seam me-1"></i>{{ $product->weight }}
                                        </span>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title mb-3" style="cursor: pointer; min-height: 48px;" onclick="window.location.href='{{ url('/products/' . $product->id) }}'">
                                            {{ $product->name }}
                                        </h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                @if($product->is_best_seller)
                                                <div>
                                                    <span class="text-muted text-decoration-line-through d-block" style="font-size: 0.9rem;">
                                                        {{ number_format($product->original_price ?? $product->price) }}₫
                                                    </span>
                                                    <span class="text-danger fw-bold fs-5">
                                                        {{ number_format($product->display_price) }}₫
                                                    </span>
                                                </div>
                                                @else
                                                <span class="fw-bold fs-5" style="color: #936f03;">
                                                    {{ number_format($product->price) }}₫
                                                </span>
                                                @endif
                                            </div>
                                            <form action="{{ url('/cart/add/' . $product->id) }}" method="POST" class="add-to-cart-form"
                                                  data-product-name="{{ $product->name }}"
                                                  data-product-image="{{ $product->image ? asset('storage/'.$product->image) : asset('images/products/product-1.jpg') }}"
                                                  data-product-price="{{ number_format($product->display_price ?? $product->price, 0, ',', '.') }}">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-sm" style="background: #936f03; color: white; border-radius: 50%; width: 40px; height: 40px;">
                                                    <i class="bi bi-cart-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    <div class="carousel-item active">
                        <div class="text-center py-5">
                            <p class="text-muted">Chưa có sản phẩm nổi bật</p>
                        </div>
                    </div>
                    @endforelse
                    
                    {{-- Tablet slides --}}
                    @forelse($tabletChunks as $index => $chunk)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }} d-none d-md-block d-lg-none">
                        <div class="row g-4">
                            @foreach($chunk as $product)
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; transition: transform 0.3s;">
                                    <div class="position-relative" style="height: 250px; overflow: hidden;">
                                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/products/product-1.jpg') }}" 
                                             class="card-img-top w-100 h-100" 
                                             style="object-fit: cover; cursor: pointer;"
                                             alt="{{ $product->name }}"
                                             onclick="window.location.href='{{ url('/products/' . $product->id) }}'">
                                        @if($product->is_best_seller)
                                        <span class="position-absolute top-0 start-0 m-3 badge bg-danger">-{{ $product->discount_percent }}%</span>
                                        @endif
                                        @if($product->weight)
                                        <span class="position-absolute bottom-0 end-0 m-3 badge bg-success">
                                            <i class="bi bi-box-seam me-1"></i>{{ $product->weight }}
                                        </span>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title mb-3" style="cursor: pointer; min-height: 48px;" onclick="window.location.href='{{ url('/products/' . $product->id) }}'">
                                            {{ $product->name }}
                                        </h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                @if($product->is_best_seller)
                                                <div>
                                                    <span class="text-muted text-decoration-line-through d-block" style="font-size: 0.9rem;">
                                                        {{ number_format($product->original_price ?? $product->price) }}₫
                                                    </span>
                                                    <span class="text-danger fw-bold fs-5">
                                                        {{ number_format($product->display_price) }}₫
                                                    </span>
                                                </div>
                                                @else
                                                <span class="fw-bold fs-5" style="color: #936f03;">
                                                    {{ number_format($product->price) }}₫
                                                </span>
                                                @endif
                                            </div>
                                            <form action="{{ url('/cart/add/' . $product->id) }}" method="POST" class="add-to-cart-form"
                                                  data-product-name="{{ $product->name }}"
                                                  data-product-image="{{ $product->image ? asset('storage/'.$product->image) : asset('images/products/product-1.jpg') }}"
                                                  data-product-price="{{ number_format($product->display_price ?? $product->price, 0, ',', '.') }}">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-sm" style="background: #936f03; color: white; border-radius: 50%; width: 40px; height: 40px;">
                                                    <i class="bi bi-cart-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    @endforelse
                    
                    {{-- Mobile slides --}}
                    @forelse($mobileChunks as $index => $chunk)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }} d-block d-md-none">
                        <div class="row g-4">
                            @foreach($chunk as $product)
                            <div class="col-6">
                                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; transition: transform 0.3s;">
                                    <div class="position-relative" style="height: 200px; overflow: hidden;">
                                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/products/product-1.jpg') }}" 
                                             class="card-img-top w-100 h-100" 
                                             style="object-fit: cover; cursor: pointer;"
                                             alt="{{ $product->name }}"
                                             onclick="window.location.href='{{ url('/products/' . $product->id) }}'">
                                        @if($product->is_best_seller)
                                        <span class="position-absolute top-0 start-0 m-2 badge bg-danger">-{{ $product->discount_percent }}%</span>
                                        @endif
                                        @if($product->weight)
                                        <span class="position-absolute bottom-0 end-0 m-2 badge bg-success" style="font-size: 0.7rem;">
                                            <i class="bi bi-box-seam me-1"></i>{{ $product->weight }}
                                        </span>
                                        @endif
                                    </div>
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-2" style="cursor: pointer; min-height: 38px; font-size: 0.85rem;" onclick="window.location.href='{{ url('/products/' . $product->id) }}'">
                                            {{ $product->name }}
                                        </h6>
                                        <div class="text-end">
                                            @if($product->is_best_seller)
                                            <div>
                                                <small class="text-muted text-decoration-line-through d-block" style="font-size: 0.75rem;">
                                                    {{ number_format($product->original_price ?? $product->price) }}₫
                                                </small>
                                                <span class="text-danger fw-bold" style="font-size: 0.9rem;">
                                                    {{ number_format($product->display_price) }}₫
                                                </span>
                                            </div>
                                            @else
                                            <span class="fw-bold" style="color: #936f03; font-size: 0.9rem;">
                                                {{ number_format($product->price) }}₫
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>

                @if($desktopChunks->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#productsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

                <!-- <div class="carousel-indicators position-static mt-4">
                    @foreach($chunks as $index => $chunk)
                    <button type="button" data-bs-target="#productsCarousel" data-bs-slide-to="{{ $index }}" 
                            class="{{ $index === 0 ? 'active' : '' }}" 
                            style="background: #936f03; width: 12px; height: 12px; border-radius: 50%;">
                    </button>
                    @endforeach
                </div> -->
                @endif
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <h2 class="text-center mb-4" style="color: #936f03;">
                                <i class="bi bi-envelope-paper me-2"></i>Gửi Tin Nhắn Cho Chúng Tôi
                            </h2>
                            <form action="/contact/send" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="tel" name="phone" class="form-control" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tiêu đề <span class="text-danger">*</span></label>
                                    <input type="text" name="subject" class="form-control" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Nội dung <span class="text-danger">*</span></label>
                                    <textarea name="message" class="form-control" rows="5" required></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-lg px-5" style="background: #936f03; color: white; border-radius: 25px;">
                                        <i class="bi bi-send me-2"></i>Gửi Tin Nhắn
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section (Optional) -->
    <!-- <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center fw-bold mb-4" style="color: #936f03;">
                <i class="bi bi-geo-alt-fill me-2"></i>Địa Chỉ Cửa Hàng
            </h2>
            <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                <div class="card-body p-0">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4616307854214!2d106.68427631533433!3d10.776530392320257!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4b3330bcc9%3A0xb3ff69197b10ec4f!2sBitexco%20Financial%20Tower!5e0!3m2!1sen!2s!4v1234567890123!5m2!1sen!2s" 
                            width="100%" 
                            height="450" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section> -->
</div>

<style>
.contact-page .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.contact-page .icon-box {
    transition: transform 0.3s;
}

.contact-page .icon-box:hover {
    transform: scale(1.1);
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: invert(1);
}

.add-to-cart-form button {
    transition: all 0.3s;
}

.add-to-cart-form button:hover {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(147, 111, 3, 0.4);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle add to cart forms with AJAX
    const cartForms = document.querySelectorAll('.add-to-cart-form');
    
    cartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const formData = new FormData(this);
            const productName = this.dataset.productName;
            const productImage = this.dataset.productImage;
            const productPrice = this.dataset.productPrice;
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show toast notification with product info
                    showToast('success', {
                        name: productName,
                        image: productImage,
                        price: productPrice
                    });
                    
                    // Update cart count badge
                    const cartBadge = document.getElementById('cart-count-badge');
                    if (cartBadge) {
                        cartBadge.textContent = data.cart_count;
                        if (data.cart_count > 0) {
                            cartBadge.classList.remove('d-none');
                        }
                    }
                    
                    // Update cart dropdown HTML
                    const cartDropdownContent = document.getElementById('cart-dropdown-content');
                    if (cartDropdownContent && data.cart_html) {
                        cartDropdownContent.innerHTML = data.cart_html;
                        // Re-attach event listeners to new dropdown content
                        if (typeof window.attachCartDropdownListeners === 'function') {
                            window.attachCartDropdownListeners();
                        }
                    }
                } else {
                    showToast('error', data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', 'Không thể thêm vào giỏ hàng');
            });
        });
    });
    
    // Toast notification function
    function showToast(type, data) {
        const toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) return;
        
        const toastId = 'toast-' + Date.now();
        
        let toastHtml = '';
        
        if (type === 'success' && typeof data === 'object' && data.name) {
            // Success toast with product info
            toastHtml = `
                <div id="${toastId}" class="toast text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="4000" style="min-width: 350px;">
                    <div class="toast-body p-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle me-2 fs-5"></i>
                            <strong>Thêm sản phẩm thành công</strong>
                            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="d-flex align-items-center gap-3 mt-2">
                            <img src="${data.image}" alt="${data.name}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                            <div class="flex-grow-1">
                                <div class="fw-medium" style="font-size: 0.95rem;">${data.name}</div>
                                <div class="mt-1" style="font-size: 0.9rem; opacity: 0.95;">${data.price}₫</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else {
            // Simple error toast
            const message = typeof data === 'string' ? data : data.message || 'Có lỗi xảy ra';
            const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
            const icon = type === 'success' ? 'bi-check-circle' : 'bi-x-circle';
            
            toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi ${icon} me-2"></i>${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
        }
        
        toastContainer.insertAdjacentHTML('beforeend', toastHtml);
        
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
        
        // Remove toast after it's hidden
        toastElement.addEventListener('hidden.bs.toast', function() {
            this.remove();
        });
    }
});
</script>
@endsection
