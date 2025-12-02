@extends('layouts.master')

@section('content')
<div class="container my-5 product-padding">
    <!-- Page Header -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none breadcrumb-link">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/products" class="text-decoration-none breadcrumb-link">Sản phẩm</a></li>
            @if(request('category'))
                <li class="breadcrumb-item active" aria-current="page">{{ request('category') }}</li>
            @elseif(request('search'))
                <li class="breadcrumb-item active" aria-current="page">Tìm kiếm</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Tất cả sản phẩm</li>
            @endif
        </ol>
    </nav>
    <div class="mb-4">
        <!-- Title -->
        <div class="category-title-wrapper-product mb-4">
            <h2 class="category-title mb-0">
                @if(request('search'))
                    Kết quả tìm kiếm: "{{ request('search') }}"
                @elseif(request('category'))
                    {{ request('category') }}
                @else
                    Tất cả sản phẩm
                @endif
            </h2>
        </div>
        
        <div class="row align-items-center">
            <!-- Left: Breadcrumb and Product Count -->
            <div class="col-md-6">
                <!-- Product Count -->
                <p class="text-muted mb-0 product-count-text">
                    <i class="bi bi-box-seam me-1"></i>
                    Tổng có <strong class="product-count-strong">{{ $products->total() }}</strong> sản phẩm
                </p>
            </div>
            
            <!-- Right: Sort Options -->
            <div class="col-md-6">
                <div class="d-flex justify-content-md-end align-items-center gap-2 mt-3 mt-md-0">
                    <label class="mb-0 me-2 text-muted sort-label">
                        <i class="bi bi-funnel me-1"></i>Sắp xếp:
                    </label>
                    <select class="form-select form-select-sm sort-select" id="sortProducts">
                        <option value="" {{ !request('sort') ? 'selected' : '' }}>Mặc định</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến cao</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến thấp</option>
                        <option value="discount" {{ request('sort') == 'discount' ? 'selected' : '' }}>Giảm giá nhiều nhất</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên: A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên: Z-A</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="product-row">
            @foreach($products as $product)
            <div class="product-col">
                <div class="product-block-card {{ $product->quantity <= 0 ? 'out-of-stock' : '' }}"
                     data-product-id="{{ $product->id }}"
                     data-product-name="{{ $product->name }}"
                     data-product-price="{{ $product->is_best_seller ? $product->display_price : $product->price }}"
                     data-product-image="{{ $product->image ? asset('storage/'.$product->image) : asset('images/products/product-1.jpg') }}"
                     data-product-quantity="{{ $product->quantity }}">
                    <div class="product-block-image-wrapper product-clickable" style="cursor: pointer;">
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/products/product-1.jpg') }}" 
                             class="product-block-image" alt="{{ $product->name }}">
                        @if($product->is_best_seller)
                        <div class="product-block-discount">-{{ $product->discount_percent }}%</div>
                        @endif
                        @if($product->weight)
                        <div style="position: absolute; bottom: 10px; right: 10px; z-index: 5;">
                            <span class="badge" style="background-color: #28a745; color: white; font-size: 0.85rem;">
                                <i class="bi bi-box-seam me-1"></i>{{ $product->weight }}
                            </span>
                        </div>
                        @endif
                        <form action="{{ url('/cart/add/' . $product->id) }}" method="POST" class="add-to-cart-form d-inline" 
                              data-product-name="{{ $product->name }}"
                              data-product-image="{{ $product->image ? asset('storage/'.$product->image) : asset('images/products/product-1.jpg') }}"
                              data-product-price="{{ number_format($product->display_price ?? $product->price, 0, ',', '.') }}">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="product-block-cart-icon">
                                <i class="bi bi-cart-plus text-white fs-4"></i>
                            </button>
                        </form>
                    </div>
                    <div class="product-block-body product-clickable" style="cursor: pointer;">
                        <h5 class="product-block-title">{{ $product->name }}</h5>
                        <div class="product-block-price-section text-end">
                            @if($product->is_best_seller)
                            <div>
                                <span class="product-block-price-old">{{ number_format($product->original_price ?? $product->price) }}₫</span>
                                <span class="product-block-price-new">{{ number_format($product->display_price) }}₫</span>
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
                        <button class="btn product-block-btn w-100 product-order-btn">Đặt hàng ngay</button>
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
            <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
            <p class="text-muted mt-3 fs-5">Không tìm thấy sản phẩm nào</p>
            <a href="/products" class="btn btn-primary mt-2">
                <i class="bi bi-arrow-left"></i> Xem tất cả sản phẩm
            </a>
        </div>
    @endif
    <!-- Related Products Section -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="col-12 related-products-section">
        <h3 class="category-title-2 mb-4 text-left related-products-title">Sản Phẩm Liên Quan</h3>
        <div id="relatedProductsCarousel" class="carousel slide position-relative related-products-carousel" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
                @foreach($relatedProducts->chunk(4) as $index => $chunk)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="d-flex justify-content-center gap-3">
                        @foreach($chunk as $product)
                        <div class="related-product-card">
                            <div class="card h-100 shadow-sm border-1 related-product-card-inner">
                                <div class="related-product-image-wrapper">
                                    <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/products/product-1.jpg') }}" 
                                         class="card-img-top related-product-image" 
                                         onmouseover="this.style.transform='scale(1.1)'"
                                         onmouseout="this.style.transform='scale(1)'"
                                         onclick="window.location.href='{{ url('/products/' . $product->id) }}'"
                                         alt="{{ $product->name }}">
                                    @if($product->is_best_seller)
                                    <div class="related-product-discount-badge">
                                        -{{ $product->discount_percent }}%
                                    </div>
                                    @endif
                                    @if($product->weight)
                                    <div style="position: absolute; bottom: 8px; right: 8px; z-index: 5;">
                                        <small class="badge bg-info" style="font-size: 0.7rem;">
                                            <i class="bi bi-box-seam"></i> {{ $product->weight }}
                                        </small>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body p-2 related-product-body" onclick="window.location.href='{{ url('/products/' . $product->id) }}'">
                                    <h6 class="card-title mb-2 related-product-title">{{ $product->name }}</h6>
                                    <div class="text-end">
                                        @if($product->is_best_seller)
                                        <div class="mb-1">
                                            <small class="text-muted text-decoration-line-through me-1 related-product-price-old">{{ number_format($product->price) }}₫</small>
                                            <span class="text-danger fw-bold related-product-price-new">{{ number_format($product->display_price) }}₫</span>
                                        </div>
                                        @else
                                        <p class="text-dark fw-bold mb-1 related-product-price-new">{{ number_format($product->price) }}₫</p>
                                        @endif
                                        <div class="text-end">
                                            @if($product->quantity > 0)
                                                <small class="badge bg-success" style="font-size: 0.7rem;">Còn {{ $product->quantity }} sản phẩm</small>
                                            @else
                                                <small class="badge bg-danger" style="font-size: 0.7rem;">Hết hàng</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($relatedProducts->count() > 4)
            <button class="carousel-control-prev related-products-control-prev" type="button" data-bs-target="#relatedProductsCarousel" data-bs-slide="prev">
                <span class="d-flex align-items-center justify-content-center rounded-circle related-products-control-icon" aria-hidden="true">
                    <i class="bi bi-chevron-left text-white fs-5"></i>
                </span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next related-products-control-next" type="button" data-bs-target="#relatedProductsCarousel" data-bs-slide="next">
                <span class="d-flex align-items-center justify-content-center rounded-circle related-products-control-icon" aria-hidden="true">
                    <i class="bi bi-chevron-right text-white fs-5"></i>
                </span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif
        </div>
    </div>
    @endif

    <!-- Promotion Products Section - Only show on main products page -->
    @if(!request('category') && !request('search'))
    @php
        $promotionProducts = App\Models\Product::whereNotNull('sale_price')
            ->where('discount_percent', '>', 0)
            ->orderBy('discount_percent', 'desc')
            ->get();
    @endphp
    @if($promotionProducts->count() > 0)
    <div class="col-12 mt-5 mb-5">
        <div class="mb-4">
            <h3 class="fw-bold d-inline-block mb-0" style="border-bottom: 3px solid #dc3545; padding-bottom: 0.5rem; color: #936f03;">
                <i class="bi bi-fire text-danger me-2"></i>Sản Phẩm Khuyến Mãi
            </h3>
        </div>
        <div id="promotionProductsCarousel" class="carousel slide position-relative promotion-carousel" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
                @foreach($promotionProducts->chunk(4) as $index => $chunk)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="d-flex justify-content-center promotion-carousel-items">
                        @foreach($chunk as $product)
                        <div class="promotion-product-item">
                            <a href="{{ url('/products/' . $product->id) }}" class="text-decoration-none">
                                <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                                    <div style="position: relative; overflow: hidden;">
                                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/products/product-1.jpg') }}" 
                                             class="card-img-top" 
                                             style="height: 220px; object-fit: cover;"
                                             alt="{{ $product->name }}">
                                        @if($product->has_sale)
                                        <div style="position: absolute; top: 8px; right: 8px; background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold; font-size: 0.85rem; z-index: 5;">
                                            -{{ $product->discount_percent }}%
                                        </div>
                                        @endif
                                        <div style="position: absolute; top: 8px; left: 8px; z-index: 5;">
                                            <span class="badge bg-danger">
                                                <i class="bi bi-lightning-fill"></i> SALE
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="card-title mb-2" style="font-size: 0.95rem; line-height: 1.3; height: 2.6rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $product->name }}</h6>
                                        <div class="text-end">
                                            @if($product->has_sale)
                                            <div class="mb-1">
                                                <small class="text-muted text-decoration-line-through me-2" style="font-size: 0.8rem;">{{ number_format($product->original_price ?? $product->price) }}₫</small>
                                                <span class="text-danger fw-bold" style="font-size: 1rem;">{{ number_format($product->display_price) }}₫</span>
                                            </div>
                                            <div class="mb-1">
                                                <small class="text-danger fw-bold" style="font-size: 0.75rem;">
                                                    Tiết kiệm: {{ number_format(($product->original_price ?? $product->price) - $product->display_price) }}₫
                                                </small>
                                            </div>
                                            @else
                                            <p class="text-dark fw-bold mb-1" style="font-size: 1rem;">{{ number_format($product->price) }}₫</p>
                                            @endif
                                            <div>
                                                @if($product->quantity > 0)
                                                    <small class="badge bg-success" style="font-size: 0.7rem;">Còn {{ $product->quantity }} sản phẩm</small>
                                                @else
                                                    <small class="badge bg-danger" style="font-size: 0.7rem;">Hết hàng</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            @if($promotionProducts->count() > 4)
            <button class="carousel-control-prev promotion-carousel-prev" type="button" data-bs-target="#promotionProductsCarousel" data-bs-slide="prev">
                <span class="d-flex align-items-center justify-content-center rounded-circle promotion-carousel-icon" aria-hidden="true">
                    <i class="bi bi-chevron-left text-white fs-5"></i>
                </span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next promotion-carousel-next" type="button" data-bs-target="#promotionProductsCarousel" data-bs-slide="next">
                <span class="d-flex align-items-center justify-content-center rounded-circle promotion-carousel-icon" aria-hidden="true">
                    <i class="bi bi-chevron-right text-white fs-5"></i>
                </span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif
        </div>
    </div>
    @endif
    @endif

    <!-- News Section - Only show on main products page -->
    @if(!request('category') && !request('search'))
    <div class="col-12 mt-5">
        <div class="text-center mb-4">
            <h3 class="fw-bold d-inline-block mb-0" style="border-bottom: 3px solid #dc3545; padding-bottom: 0.5rem; color: #936f03;">
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
    @endif

</div>

<!-- Category Information Section -->
@if(request('category'))
    @if(request('category') == 'Yến Thô')
        @include('partials.yen-tho-info')
    @elseif(request('category') == 'Yến Tinh Chế')
        @include('partials.yen-tinh-che-info')
    @elseif(request('category') == 'Yến Chưng Sẵn')
        @include('partials.yen-chung-san-info')
    @endif
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle sort products
    const sortSelect = document.getElementById('sortProducts');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const url = new URL(window.location.href);
            
            if (sortValue) {
                url.searchParams.set('sort', sortValue);
            } else {
                url.searchParams.delete('sort');
            }
            
            window.location.href = url.toString();
        });
    }
});
</script>

@include('partials.mobile-product-modal')

@endsection
