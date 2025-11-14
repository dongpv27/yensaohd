@extends('layouts.master')

@section('content')
    <!-- Banner / Carousel -->
    <div class="container">
        <div id="homeCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/banners/slide1.jpg') }}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="display-4 fw-bold">Tinh Hoa Từ Tổ Yến</h3>
                        <p class="lead">Chất lượng từ tâm</p>
                    </div>
                </div>
            <div class="carousel-item">
                <img src="{{ asset('images/banners/slide2.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/banners/slide3.jpg') }}" class="d-block w-100" alt="...">
            </div>
        </div>
    </div>

    <!-- Sản phẩm bán chạy -->
    <section class="mb-5 position-relative best-seller-section">
        <div class="container-fluid px-4">
            <h2 class="mb-3 fw-bold text-start best-seller-title">
                <i class="bi bi-fire"></i> Sản Phẩm Bán Chạy
            </h2>
        </div>
        <hr class="mb-4 mx-0 best-seller-divider">
        <div class="container">
            <div id="bestSellerCarousel" class="carousel slide position-relative best-seller-carousel" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-inner">
                    @foreach($bestSellers->chunk(5) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row row-cols-2 row-cols-md-5 g-3">
                            @foreach($chunk as $key => $product)
                            <div class="col">
                                <a href="{{ url('/products/' . $product->id) }}" class="text-decoration-none">
                                    <div class="card h-100 shadow-sm position-relative product-card">
                                        @if($product->has_sale)
                                        <div class="discount-badge">
                                            <span class="badge bg-danger fs-6">-{{ $product->discount_percent }}%</span>
                                        </div>
                                        @endif
                                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/products/product-1.jpg') }}" 
                                             class="card-img-top product-image" alt="{{ $product->name }}">
                                        <div class="card-body p-3">
                                            <h6 class="card-title text-truncate mb-3 fw-bold text-start text-dark product-title">{{ $product->name }}</h6>
                                            <div class="price-section d-flex justify-content-between align-items-center mb-2">
                                                @if($product->has_sale)
                                                <p class="text-muted text-decoration-line-through mb-0 product-price-old">
                                                    {{ number_format($product->original_price ?? $product->price) }}₫
                                                </p>
                                                <p class="text-danger fw-bold mb-0 product-price-new">
                                                    {{ number_format($product->sale_price) }}₫
                                                </p>
                                                @else
                                                <p class="text-dark fw-bold mb-0 ms-auto product-price-new">
                                                    {{ number_format($product->price) }}₫
                                                </p>
                                                @endif
                                            </div>
                                            <div class="text-end">
                                                <small class="text-muted fst-italic product-sold-count">Đã bán: {{ $product->sold_count }}</small>
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
                @if($bestSellers->count() > 5)
                <button class="carousel-control-prev carousel-control-custom-prev" type="button" data-bs-target="#bestSellerCarousel" data-bs-slide="prev">
                    <span class="d-flex align-items-center justify-content-center rounded-circle carousel-control-icon" aria-hidden="true">
                        <i class="bi bi-chevron-left text-white fs-4"></i>
                    </span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next carousel-control-custom-next" type="button" data-bs-target="#bestSellerCarousel" data-bs-slide="next">
                    <span class="d-flex align-items-center justify-content-center rounded-circle carousel-control-icon" aria-hidden="true">
                        <i class="bi bi-chevron-right text-white fs-4"></i>
                    </span>
                    <span class="visually-hidden">Next</span>
                </button>
                @endif
            </div>
        </div>
    </section>

    <!-- Product Blocks -->
    <div class="container">
        <section class="mb-5">
            <div class="category-title-wrapper">
                <h2 class="category-title mb-0">Yến Thô Tự Nhiên</h2>
            </div>
            <p class="text-muted mb-4 text-start">Tổ yến nguyên chất, giữ trọn dưỡng chất tự nhiên.</p>
            <div class="product-row">
                @for($i=1;$i<=4;$i++)
                <div class="product-col">
                    <div class="product-block-card">
                        <div class="product-block-image-wrapper">
                            <img src="https://placehold.co/600x400/e8e8e8/333333?text=San+pham+Tho" class="product-block-image" alt="Sản phẩm Thô">
                            @if($i % 2 == 0)
                            <div class="product-block-discount">-20%</div>
                            @endif
                            <div class="product-block-cart-icon">
                                <i class="bi bi-cart-plus text-white fs-4"></i>
                            </div>
                        </div>
                        <div class="product-block-body">
                            <h5 class="product-block-title">Sản phẩm Thô #{{ $i }}</h5>
                            <div class="product-block-price-section">
                                @if($i % 2 == 0)
                                <span class="product-block-price-old">1,000,000₫</span>
                                <span class="product-block-price-new">800,000₫</span>
                                @else
                                <span class="product-block-price-new">1,000,000₫</span>
                                @endif
                            </div>
                            <a href="#" class="btn product-block-btn w-100">Đặt hàng ngay</a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </section>
    </div>

    <section class="mb-5 py-4" style="background-color:#FFF4C1">
        <div class="container">
            <div class="category-title-wrapper">
                <h2 class="category-title mb-0">Yến Tinh Chế</h2>
            </div>
            <p class="text-muted mb-4 text-start">Tinh chọn từng sợi yến, sạch lông, sẵn sàng cho bữa bổ dưỡng.</p>
            <div class="product-row">
                @for($i=1;$i<=4;$i++)
                <div class="product-col">
                    <div class="product-block-card">
                        <div class="product-block-image-wrapper">
                            <img src="https://placehold.co/600x400/e8e8e8/333333?text=San+pham+Tinh+Che" class="product-block-image" alt="Sản phẩm Tinh Chế">
                            @if($i % 3 == 0)
                            <div class="product-block-discount">-15%</div>
                            @endif
                            <div class="product-block-cart-icon">
                                <i class="bi bi-cart-plus text-white fs-4"></i>
                            </div>
                        </div>
                        <div class="product-block-body">
                            <h5 class="product-block-title">Sản phẩm Tinh Chế #{{ $i }}</h5>
                            <div class="product-block-price-section">
                                @if($i % 3 == 0)
                                <span class="product-block-price-old">1,500,000₫</span>
                                <span class="product-block-price-new">1,275,000₫</span>
                                @else
                                <span class="product-block-price-new">1,500,000₫</span>
                                @endif
                            </div>
                            <a href="#" class="btn product-block-btn w-100">Đặt hàng ngay</a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </section>
    </section>

    <div class="container">
        <section class="mb-5">
            <div class="category-title-wrapper">
                <h2 class="category-title mb-0">Yến Chưng Sẵn</h2>
            </div>
            <p class="text-muted mb-4 text-start">Yến chưng sẵn tiện lợi – bổ dưỡng mỗi ngày.</p>
            <div class="product-row">
                @for($i=1;$i<=4;$i++)
                <div class="product-col">
                    <div class="product-block-card">
                        <div class="product-block-image-wrapper">
                            <img src="https://placehold.co/600x400/e8e8e8/333333?text=San+pham+Chung+San" class="product-block-image" alt="Sản phẩm Chưng Sẵn">
                            <div class="product-block-cart-icon">
                                <i class="bi bi-cart-plus text-white fs-4"></i>
                            </div>
                        </div>
                        <div class="product-block-body">
                            <h5 class="product-block-title">Sản phẩm Chưng Sẵn #{{ $i }}</h5>
                            <div class="product-block-price-section">
                                <span class="product-block-price-new">200,000₫</span>
                            </div>
                            <a href="#" class="btn product-block-btn w-100">Đặt hàng ngay</a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </section>
    </div>

    <!-- Customer reviews & contact form (placeholder) -->
    <div class="container">
        <section class="mb-5 row">
            <div class="col-md-7">
            <h4>Ý kiến khách hàng</h4>
            <div class="bg-light p-3">
                <p><strong>Nguyễn A:</strong> Sản phẩm rất tốt, đóng gói kỹ.</p>
                <p><strong>Trần B:</strong> Dịch vụ nhanh, nhân viên thân thiện.</p>
            </div>
        </div>
        <div class="col-md-5">
            <h4>Form tư vấn</h4>
            <form>
                <div class="mb-2">
                    <input class="form-control" placeholder="Họ và tên">
                </div>
                <div class="mb-2">
                    <input class="form-control" placeholder="SĐT">
                </div>
                <div class="mb-2">
                    <input class="form-control" placeholder="Email">
                </div>
                <div class="mb-2">
                    <textarea class="form-control" rows="3" placeholder="Nội dung"></textarea>
                </div>
                <button class="btn" style="background-color:#F5B041;color:#000">Gửi tư vấn</button>
            </form>
        </div>
    </section>

@endsection
