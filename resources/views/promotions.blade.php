@extends('layouts.master')

@section('content')
<div class="container my-5">
    <!-- Page Header -->
    <div class="mb-5 text-center">
        <h1 class="fw-bold mb-3">
            <i class="bi bi-fire text-danger"></i> 
            KHUYẾN MÃI HOT
        </h1>
        <p class="text-muted fs-5">Săn ngay các sản phẩm đang giảm giá hấp dẫn</p>
        <hr class="w-25 mx-auto border-danger border-2">
    </div>

    <!-- Filter & Count -->
    <div class="row mb-4 align-items-center ">
        <div class="col-md-6 padding-b">
            <h5 class="mb-0 promotions-header">
                <span class="badge bg-danger promo-count-badge">{{ $products->total() }} sản phẩm</span>
                <span class="promo-count-text">đang được khuyến mãi</span>
            </h5>
        </div>
        <div class="col-md-6 text-end">
            <div class="btn-group" role="group">
                <a href="/promotions" class="btn btn-outline-danger {{ !request('sort') ? 'active' : '' }}">Tất cả</a>
                <a href="/promotions?sort=discount" class="btn btn-outline-danger {{ request('sort') == 'discount' ? 'active' : '' }}">Giảm giá cao</a>
                <a href="/promotions?sort=newest" class="btn btn-outline-danger {{ request('sort') == 'newest' ? 'active' : '' }}">Mới nhất</a>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="product-row">
            @foreach($products as $product)
            <div class="product-col">
                <div class="product-block-card">
                    <div class="product-block-image-wrapper" style="cursor: pointer;">
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/products/product-1.jpg') }}" 
                             class="product-block-image" alt="{{ $product->name }}"
                             onclick="window.location.href='{{ url('/products/' . $product->id) }}'">
                        @if($product->is_best_seller)
                        <div class="product-block-discount" onclick="window.location.href='{{ url('/products/' . $product->id) }}'">
                            -{{ $product->discount_percent }}%
                        </div>
                        @endif
                        
                        <!-- Sale Badge -->
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-danger">
                                <i class="bi bi-lightning-fill"></i> SALE
                            </span>
                        </div>
                        
                        <form action="{{ url('/cart/add/' . $product->id) }}" method="POST" class="add-to-cart-form d-inline" data-product-name="{{ $product->name }}">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="product-block-cart-icon">
                                <i class="bi bi-cart-plus text-white fs-4"></i>
                            </button>
                        </form>
                    </div>
                    <div class="product-block-body" style="cursor: pointer;">
                        <h5 class="product-block-title" onclick="window.location.href='{{ url('/products/' . $product->id) }}'">
                            {{ $product->name }}
                        </h5>
                        <div class="product-block-price-section text-end" onclick="window.location.href='{{ url('/products/' . $product->id) }}'">
                            @if($product->is_best_seller)
                            <div>
                                <span class="product-block-price-old">{{ number_format($product->original_price ?? $product->price) }}₫</span>
                                <span class="product-block-price-new text-danger">{{ number_format($product->display_price) }}₫</span>
                            </div>
                            <div class="mt-1">
                                <small class="text-danger fw-bold">
                                    Tiết kiệm: {{ number_format(($product->original_price ?? $product->price) - $product->display_price) }}₫
                                </small>
                            </div>
                            @else
                            <div><span class="product-block-price-new">{{ number_format($product->price) }}₫</span></div>
                            @endif
                            <div class="mt-2">
                                @if($product->quantity > 0)
                                    <span class="badge bg-success">Còn {{ $product->quantity }} sản phẩm</span>
                                @else
                                    <span class="badge bg-danger">Hết hàng</span>
                                @endif
                            </div>
                        </div>
                        <button class="btn product-block-btn w-100" onclick="window.location.href='{{ url('/products/' . $product->id) }}'">
                            <i class="bi bi-cart-plus me-2"></i>Mua ngay
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {{ $products->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-tag" style="font-size: 5rem; color: #ccc;"></i>
            <h3 class="text-muted mt-3">Hiện tại chưa có sản phẩm khuyến mãi nào</h3>
            <p class="text-muted">Vui lòng quay lại sau hoặc xem các sản phẩm khác</p>
            <a href="/products" class="btn btn-primary mt-3">
                <i class="bi bi-shop me-2"></i>Xem tất cả sản phẩm
            </a>
        </div>
    @endif

    <!-- Promotion Banner -->
    @if($products->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <div class="alert alert-danger border-0 shadow-sm" role="alert">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="alert-heading mb-2">
                            <i class="bi bi-megaphone-fill me-2"></i>Chương trình khuyến mãi đặc biệt!
                        </h4>
                        <p class="mb-0">
                            Giảm giá lên đến <strong>{{ $products->max('discount_percent') }}%</strong> cho các sản phẩm yến sào cao cấp. 
                            Nhanh tay đặt hàng để nhận ưu đãi tốt nhất!
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="/products" class="btn btn-light btn-lg">
                            <i class="bi bi-eye me-2"></i>Xem thêm sản phẩm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- News Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="text-center mb-4">
                <h2 class="fw-bold d-inline-block mb-0" style="border-bottom: 3px solid #dc3545; padding-bottom: 0.5rem; color: #936f03;">
                    <i class="bi bi-newspaper me-2"></i>Tin Tức Nổi Bật
                </h2>
            </div>
            @php
                $latestNews = App\Models\News::orderBy('created_at', 'desc')->take(4)->get();
            @endphp
            @if($latestNews->count() > 0)
            <div class="row g-4">
                <!-- Featured News (Large) -->
                <div class="col-md-7">
                    @if($latestNews->first())
                    @php $featuredNews = $latestNews->first(); @endphp
                    <a href="{{ url('/news/' . $featuredNews->slug) }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0 news-card" style="border-radius: 12px; overflow: hidden;">
                            <div style="position: relative; overflow: hidden; height: 400px;">
                                <img src="{{ $featuredNews->image ? asset('storage/'.$featuredNews->image) : asset('images/banners/logo.png') }}" 
                                     class="card-img-top" 
                                     style="height: 100%; width: 100%; object-fit: cover; transition: transform 0.3s ease;"
                                     alt="{{ $featuredNews->title }}">
                            </div>
                            <div class="card-body" style="padding: 1.5rem;">
                                <h4 class="card-title" style="font-size: 1.4rem; font-weight: 600; line-height: 1.4; margin-bottom: 1rem; color: #333;">
                                    {{ $featuredNews->title }}
                                </h4>
                                <p class="card-text text-muted" style="font-size: 0.95rem; line-height: 1.6;">
                                    {{ $featuredNews->excerpt ?? Str::limit(strip_tags($featuredNews->content), 150) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>{{ $featuredNews->created_at->format('d/m/Y') }}
                                    </small>
                                    <span class="text-danger fw-bold" style="font-size: 0.9rem;">
                                        Đọc tiếp <i class="bi bi-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endif
                </div>

                <!-- Small News List (Right) -->
                <div class="col-md-5">
                    <div class="d-flex flex-column" style="gap: 1rem;">
                        @foreach($latestNews->skip(1)->take(3) as $news)
                        <a href="{{ url('/news/' . $news->slug) }}" class="text-decoration-none">
                            <div class="card shadow-sm border-0 news-card" style="border-radius: 10px; overflow: hidden;">
                                <div class="row g-0">
                                    <div class="col-5">
                                        <div style="height: 120px; overflow: hidden;">
                                            <img src="{{ $news->image ? asset('storage/'.$news->image) : asset('images/banners/logo.png') }}" 
                                                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                                                 alt="{{ $news->title }}">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="card-body" style="padding: 1rem;">
                                            <h6 class="card-title mb-2" style="font-size: 0.95rem; line-height: 1.4; height: 4.2rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; color: #333; font-weight: 600;">
                                                {{ $news->title }}
                                            </h6>
                                            <small class="text-muted" style="font-size: 0.8rem;">
                                                <i class="bi bi-calendar3 me-1"></i>{{ $news->created_at->format('d/m/Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ url('/news') }}" class="btn btn-outline-danger btn-lg" style="text-transform: uppercase; font-weight: 600; border-width: 2px; padding: 0.6rem 2rem;">
                            XEM THÊM
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Chưa có tin tức nào.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

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
                    // Show toast notification
                    showToast('success', data.message || 'Đã thêm "' + productName + '" vào giỏ hàng');
                    
                    // Update cart count badge
                    const cartBadge = document.getElementById('cart-count-badge');
                    if (cartBadge) {
                        cartBadge.textContent = data.cart_count;
                        if (data.cart_count > 0) {
                            cartBadge.classList.remove('d-none');
                        }
                    }
                    
                    // Update cart dropdown HTML
                    const cartDropdown = document.getElementById('cart-dropdown');
                    if (cartDropdown && data.cart_html) {
                        cartDropdown.innerHTML = data.cart_html;
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
    function showToast(type, message) {
        const toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) return;
        
        const toastId = 'toast-' + Date.now();
        const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
        const icon = type === 'success' ? 'bi-check-circle' : 'bi-x-circle';
        
        const toastHtml = `
            <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi ${icon} me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
        
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
