@extends('layouts.master')

@section('content')
<div class="about-page">
    <!-- Hero Section -->
    <section class="about-hero py-5" style="background: linear-gradient(135deg, #936f03 0%, #413e38 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-white mb-4 mb-lg-0">
                    <h1 class="fw-bold mb-4" style="font-size: 2.8rem;">VỀ CHÚNG TÔI</h1>
                    <p class="lead mb-4" style="font-size: 1.2rem;">
                        Yến Sào Hoàng Đăng - Hành trình mang đến sản phẩm yến sào thiên nhiên cao cấp, 
                        uy tín và chất lượng hàng đầu tại Việt Nam
                    </p>
                    <div class="d-flex align-items-center gap-4 mt-4">
                        <div class="text-center">
                            <div class="fw-bold" style="font-size: 2.5rem;">15+</div>
                            <div style="font-size: 0.95rem;">Năm kinh nghiệm</div>
                        </div>
                        <div class="text-center">
                            <div class="fw-bold" style="font-size: 2.5rem;">10K+</div>
                            <div style="font-size: 0.95rem;">Khách hàng tin tưởng</div>
                        </div>
                        <div class="text-center">
                            <div class="fw-bold" style="font-size: 2.5rem;">100%</div>
                            <div style="font-size: 0.95rem;">Yến thiên nhiên</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/banners/logo.png') }}" alt="Yến Sào Hoàng Đăng" class="img-fluid" style="max-width: 400px; filter: drop-shadow(0 10px 30px rgba(0,0,0,0.3));">
                </div>
            </div>
        </div>
    </section>

    <!-- About Content Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Story -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #936f03, #c49b33); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-book-fill text-white fs-3"></i>
                                </div>
                                <h3 class="mb-0 fw-bold" style="color: #936f03;">Câu Chuyện Của Chúng Tôi</h3>
                            </div>
                            <p class="text-muted mb-3" style="line-height: 1.8;">
                                Được thành lập từ năm 2010, <strong>Yến Sào Hoàng Đăng</strong> khởi nguồn từ niềm đam mê và tâm huyết 
                                với sản phẩm yến sào thiên nhiên cao cấp. Chúng tôi tự hào là một trong những đơn vị tiên phong 
                                trong việc cung cấp yến sào nguyên chất, không pha trộn, đạt chuẩn chất lượng quốc tế.
                            </p>
                            <p class="text-muted mb-0" style="line-height: 1.8;">
                                Với hơn 15 năm kinh nghiệm trong ngành, chúng tôi đã xây dựng được mối quan hệ bền vững 
                                với các nhà cung cấp yến sào uy tín tại các vùng nguyên liệu nổi tiếng như Indonesia, Malaysia và Việt Nam.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Mission & Vision -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #936f03, #c49b33); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-bullseye text-white fs-3"></i>
                                </div>
                                <h3 class="mb-0 fw-bold" style="color: #936f03;">Sứ Mệnh & Tầm Nhìn</h3>
                            </div>
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3" style="color: #936f03;">
                                    <i class="bi bi-check-circle-fill me-2"></i>Sứ Mệnh
                                </h5>
                                <p class="text-muted" style="line-height: 1.8;">
                                    Mang đến cho khách hàng những sản phẩm yến sào thiên nhiên chất lượng cao nhất, 
                                    góp phần nâng cao sức khỏe và chất lượng cuộc sống của mọi người.
                                </p>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3" style="color: #936f03;">
                                    <i class="bi bi-eye-fill me-2"></i>Tầm Nhìn
                                </h5>
                                <p class="text-muted mb-0" style="line-height: 1.8;">
                                    Trở thành thương hiệu yến sào hàng đầu Việt Nam, được khách hàng tin tưởng 
                                    và lựa chọn bởi chất lượng vượt trội và dịch vụ hoàn hảo.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3" style="color: #936f03;">
                    <i class="bi bi-gem me-2"></i>GIÁ TRỊ CỐT LÕII
                </h2>
                <p class="text-muted">Những giá trị làm nên thương hiệu Yến Sào Hoàng Đăng</p>
            </div>

            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 15px; transition: transform 0.3s;">
                        <div class="card-body p-4">
                            <div class="icon-box mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #936f03, #c49b33); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-shield-check text-white" style="font-size: 2.5rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: #936f03;">Chất Lượng</h5>
                            <p class="text-muted small mb-0">100% yến sào thiên nhiên, nguyên chất</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 15px; transition: transform 0.3s;">
                        <div class="card-body p-4">
                            <div class="icon-box mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #936f03, #c49b33); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-heart text-white" style="font-size: 2.5rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: #936f03;">Tận Tâm</h5>
                            <p class="text-muted small mb-0">Phục vụ khách hàng với trái tim</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 15px; transition: transform 0.3s;">
                        <div class="card-body p-4">
                            <div class="icon-box mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #936f03, #c49b33); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-award text-white" style="font-size: 2.5rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: #936f03;">Uy Tín</h5>
                            <p class="text-muted small mb-0">Cam kết nguồn gốc rõ ràng</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 15px; transition: transform 0.3s;">
                        <div class="card-body p-4">
                            <div class="icon-box mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #936f03, #c49b33); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-speedometer2 text-white" style="font-size: 2.5rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: #936f03;">Nhanh Chóng</h5>
                            <p class="text-muted small mb-0">Giao hàng tận nơi, tiện lợi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Slider Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3" style="color: #936f03;">
                    <i class="bi bi-star-fill me-2"></i>SẢN PHẨM CỦA CHÚNG TÔI
                </h2>
                <p class="text-muted">Những sản phẩm yến sào cao cấp được khách hàng yêu thích nhất</p>
            </div>

            <div id="productsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php
                        $bestSellerProducts = App\Models\Product::where('is_best_seller', true)
                            ->take(12)
                            ->get();
                        $chunks = $bestSellerProducts->chunk(4);
                    @endphp

                    @forelse($chunks as $index => $chunk)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="row g-4">
                            @foreach($chunk as $product)
                            <div class="col-lg-3 col-md-6">
                                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; transition: transform 0.3s;">
                                    <div class="position-relative" style="height: 250px; overflow: hidden;">
                                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/products/product-1.jpg') }}" 
                                             class="card-img-top w-100 h-100" 
                                             style="object-fit: cover; cursor: pointer;"
                                             alt="{{ $product->name }}"
                                             onclick="window.location.href='{{ url('/products/' . $product->id) }}'">
                                        @if($product->has_sale)
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
                                                @if($product->has_sale)
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
                            <p class="text-muted">Chưa có sản phẩm</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                @if($chunks->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#productsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

                <div class="carousel-indicators position-static mt-4">
                    @foreach($chunks as $index => $chunk)
                    <button type="button" data-bs-target="#productsCarousel" data-bs-slide-to="{{ $index }}" 
                            class="{{ $index === 0 ? 'active' : '' }}" 
                            style="background: #936f03; width: 12px; height: 12px; border-radius: 50%;">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0" style="color: #936f03;">
                    <i class="bi bi-newspaper me-2"></i>
                    <span style="border-bottom: 3px solid #936f03; padding-bottom: 5px;">TIN TỨC NỔI BẬT</span>
                </h2>
                <a href="/news" class="text-decoration-none fw-bold" style="color: #936f03;">
                    Xem tất cả <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            @php
                $latestNews = App\Models\News::orderBy('created_at', 'desc')->take(4)->get();
                $firstNews = $latestNews->first();
                $otherNews = $latestNews->skip(1)->take(3);
            @endphp

            @if($latestNews->count() > 0)
            <div class="row g-4">
                <!-- Large Featured News -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; cursor: pointer;" onclick="window.location.href='/news/{{ $firstNews->slug }}'">
                        <div style="height: 400px; overflow: hidden;">
                            <img src="{{ $firstNews->image ? asset('storage/'.$firstNews->image) : asset('images/news/default.jpg') }}" 
                                 class="card-img-top w-100 h-100" 
                                 style="object-fit: cover; transition: transform 0.3s;"
                                 alt="{{ $firstNews->title }}">
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3 text-muted small">
                                <span><i class="bi bi-calendar3 me-1"></i>{{ $firstNews->created_at->format('d/m/Y') }}</span>
                                <span><i class="bi bi-eye me-1"></i>{{ $firstNews->views ?? 0 }} lượt xem</span>
                            </div>
                            <h4 class="fw-bold mb-3">{{ $firstNews->title }}</h4>
                            <p class="text-muted mb-0">{{ Str::limit($firstNews->summary ?? $firstNews->content, 150) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Small News Items -->
                <div class="col-lg-6">
                    <div class="row g-4">
                        @foreach($otherNews as $news)
                        <div class="col-12">
                            <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden; cursor: pointer; transition: transform 0.3s;" onclick="window.location.href='/news/{{ $news->slug }}'">
                                <div class="row g-0">
                                    <div class="col-4">
                                        <div style="height: 120px; overflow: hidden;">
                                            <img src="{{ $news->image ? asset('storage/'.$news->image) : asset('images/news/default.jpg') }}" 
                                                 class="w-100 h-100" 
                                                 style="object-fit: cover;"
                                                 alt="{{ $news->title }}">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body p-3">
                                            <div class="text-muted small mb-2">
                                                <i class="bi bi-calendar3 me-1"></i>{{ $news->created_at->format('d/m/Y') }}
                                            </div>
                                            <h6 class="fw-bold mb-2">{{ Str::limit($news->title, 60) }}</h6>
                                            <p class="text-muted small mb-0">{{ Str::limit($news->summary ?? $news->content, 80) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <p class="text-muted">Chưa có tin tức nào</p>
            </div>
            @endif
        </div>
    </section>
</div>

<style>
.about-page .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.about-page .icon-box {
    transition: transform 0.3s;
}

.about-page .icon-box:hover {
    transform: scale(1.1) rotate(5deg);
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

.about-page .card img {
    transition: transform 0.3s;
}

.about-page .card:hover img {
    transform: scale(1.05);
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
