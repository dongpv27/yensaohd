@extends('layouts.master')

@section('content')
<!-- Breadcrumb -->
<div class="product-breadcrumb">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="/products?category={{ $product->category }}">{{ $product->category }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container">
    <div class="row product-details-cart">
        <!-- Product Gallery -->
        <div class="col-md-5">
            <div class="product-gallery">
                <div class="product-main-image">
                    @if($product->is_best_seller)
                        <div class="discount-badge">-{{ $product->discount_percent }}%</div>
                    @endif
                    <img src="{{ $product->image ?? asset('images/banners/logo.png') }}" alt="{{ $product->name }}" id="mainImage">
                </div>
                <div class="product-thumbnails">
                    <div class="product-thumbnail active">
                        <img src="{{ $product->image ?? asset('images/banners/logo.png') }}" alt="{{ $product->name }}">
                    </div>
                    <div class="product-thumbnail">
                        <img src="{{ $product->image ?? asset('images/banners/logo.png') }}" alt="{{ $product->name }}">
                    </div>
                    <div class="product-thumbnail">
                        <img src="{{ $product->image ?? asset('images/banners/logo.png') }}" alt="{{ $product->name }}">
                    </div>
                    <div class="product-thumbnail">
                        <img src="{{ $product->image ?? asset('images/banners/logo.png') }}" alt="{{ $product->name }}">
                    </div>
                </div>
                
                <!-- Trust Banner -->
                <div class="trust-banner">
                    <i class="bi bi-shield-check"></i>
                    Yến Sào Hoàng Đăng luôn đảm bảo 100% TỔ YẾN NGUYÊN CHẤT và KHÔNG PHA, TẨM DƯỠNG.
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-7">
            <div class="product-info">
                <h1 class="product-title">{{ $product->name }}</h1>
                
                @if($product->weight)
                <div class="mb-3">
                    <span class="badge" style="background-color: #28a745; color: white; font-size: 1rem; padding: 0.5rem 1rem;">
                        <i class="bi bi-box-seam me-2"></i>{{ $product->weight }}
                    </span>
                </div>
                @endif

                <!-- Price -->
                <div class="product-price">
                    @if($product->is_best_seller)
                        <span class="price-original">{{ number_format($product->original_price ?? $product->price, 0, ',', '.') }}₫</span>
                    @endif
                    <span class="price-sale">{{ number_format($product->display_price, 0, ',', '.') }}₫</span>
                    @if($product->is_best_seller)
                        <span class="price-discount-badge">Giảm {{ $product->discount_percent }}%</span>
                    @endif
                </div>

                <!-- Shipping Info -->
                <div class="shipping-info">
                    @if($product->weight)
                    <div class="shipping-item">
                        <div class="shipping-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="shipping-text">
                            <strong>Khối lượng</strong>
                            <small>{{ $product->weight }}</small>
                        </div>
                    </div>
                    @endif
                    <div class="shipping-item">
                        <div class="shipping-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div class="shipping-text">
                            <strong>Miễn phí vận chuyển toàn quốc</strong>
                            <small>Áp dụng cho đơn hàng từ 1.000.000đ</small>
                        </div>
                    </div>
                    <div class="shipping-item">
                        <div class="shipping-icon">
                            <i class="bi bi-gift"></i>
                        </div>
                        <div class="shipping-text">
                            <strong>Miễn phí giao hàng hỏa tốc</strong>
                            <small>Áp dụng tại TP.HCM cho đơn hàng từ 1.000.000đ</small>
                        </div>
                    </div>
                </div>

                <!-- Quantity & Actions -->
                <form action="/cart/add/{{ $product->id }}" method="POST" id="addToCartForm" class="add-to-cart-form"
                      data-product-name="{{ $product->name }}"
                      data-product-image="{{ $product->image ?? asset('images/banners/logo.png') }}"
                      data-product-price="{{ number_format($product->display_price, 0, ',', '.') }}">
                    @csrf
                    <div class="quantity-and-actions">
                        <div class="quantity-control">
                            <button type="button" class="quantity-btn" onclick="decreaseQuantity()" {{ $product->quantity <= 0 ? 'disabled' : '' }}>-</button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="quantity-input" id="quantityInput" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                            <button type="button" class="quantity-btn" onclick="increaseQuantity()" {{ $product->quantity <= 0 ? 'disabled' : '' }}>+</button>
                        </div>
                        @if($product->quantity > 0)
                        <button type="submit" class="btn-add-cart">
                            <i class="bi bi-cart-plus"></i> THÊM VÀO GIỎ HÀNG
                        </button>
                        <button type="button" class="btn-buy-now" onclick="buyNow()">
                            <i class="bi bi-lightning-fill"></i> MUA NGAY
                        </button>
                        @else
                        <button type="button" class="btn-add-cart" disabled style="cursor: not-allowed; opacity: 0.6;">
                            <i class="bi bi-x-circle"></i> HẾT HÀNG
                        </button>
                        <button type="button" class="btn-buy-now" disabled style="cursor: not-allowed; opacity: 0.6;">
                            <i class="bi bi-x-circle"></i> HẾT HÀNG
                        </button>
                        @endif
                    </div>
                </form>

                <!-- Contact Buttons -->
                <div class="contact-buttons">
                    <a href="tel:090.995.8878" class="btn-contact btn-phone">
                        <i class="bi bi-telephone-fill"></i> 090.995.8878
                    </a>
                    <a href="https://zalo.me/0909958878" target="_blank" class="btn-contact btn-zalo">
                        <i class="bi bi-chat-dots-fill"></i> ZALO
                    </a>
                </div>

                <!-- Promotion Box -->
                <div class="promotion-box-main">
                    <h6>
                        <i class="bi bi-gift-fill"></i> Khuyến mãi, Ưu đãi
                    </h6>
                    <ul>
                        <li>Tặng 1 Hộp Táo Đỏ Organic.</li>
                        <li>Tặng 1 Hộp Đường Phèn Nguyên Chất Không Tẩy.</li>
                        <li>Yến Sào Tuyển chọn nhà yến hơn 10 năm tuổi</li>
                        <li>Hoàn Ngay 200% Nếu Phát Hiện Yến Giả, Kém Chất Lượng.</li>
                    </ul>
                </div>

                <!-- Commitment Section -->
                <div class="commitment-section-main">
                    <h6 class="commitment-section-title">CAM KẾT</h6>
                    <div class="commitment-content">
                        <div class="commitment-item">
                            <div class="commitment-icon">1</div>
                            <div class="commitment-text">
                                <strong>Cam kết chính hãng</strong>
                                <p>Hoàn tiền 200% nếu phát hiện hàng giả, hàng nhái.</p>
                            </div>
                        </div>
                        <div class="commitment-item">
                            <div class="commitment-icon">2</div>
                            <div class="commitment-text">
                                <strong>Cam kết tư vấn dụng</strong>
                                <p>Chuyên gia tư vấn trực tiếp qua hotline/zalo: 0947.180.202</p>
                            </div>
                        </div>
                        <div class="commitment-item">
                            <div class="commitment-icon">3</div>
                            <div class="commitment-text">
                                <strong>Cam kết bảo mật</strong>
                                <p>Tuyệt đối không chia sẻ thông tin khách hàng cho bên thứ 3.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Section -->
    <div class="product-details-section">
        <h3 class="section-title">THÔNG TIN CHI TIẾT</h3>
        <div class="mt-4">
            <ul class="details-list">
                <li>Khai thác từ đảo thiên nhiên 100% – Đĩa hình hiếm trở</li>
                <li>Huyết yến được tinh chế làm sạch lông và tạp chất 100% với quy trình chuẩn ISO.</li>
                <li>Giữ nguyên vị yến và hàm lượng dinh dưỡng đến 99%.</li>
                <li>Quy cách đóng gói hộp 50g yến tinh chế.</li>
            </ul>
        </div>
    </div>

    <!-- Related Products Section -->
    @if($relatedProducts->count() > 0)
    <div class="mt-5">
        <h3 class="section-title mb-4">SẢN PHẨM LIÊN QUAN</h3>
        <div class="row g-4">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col-md-3 col-6">
                <div class="product-block-card {{ $relatedProduct->quantity <= 0 ? 'out-of-stock' : '' }}">
                    <div class="product-block-image-wrapper" style="cursor: pointer;">
                        <img src="{{ $relatedProduct->image ? asset('storage/'.$relatedProduct->image) : asset('images/products/product-1.jpg') }}" 
                             class="product-block-image" alt="{{ $relatedProduct->name }}"
                             onclick="window.location.href='{{ url('/products/' . $relatedProduct->id) }}'">
                        @if($relatedProduct->is_best_seller)
                        <div class="product-block-discount" onclick="window.location.href='{{ url('/products/' . $relatedProduct->id) }}'">-{{ $relatedProduct->discount_percent }}%</div>
                        @endif
                        @if($relatedProduct->weight)
                        <div style="position: absolute; bottom: 10px; right: 10px; z-index: 5;" onclick="window.location.href='{{ url('/products/' . $relatedProduct->id) }}'">
                            <span class="badge" style="background-color: #28a745; color: white; font-size: 0.85rem;">
                                <i class="bi bi-box-seam me-1"></i>{{ $relatedProduct->weight }}
                            </span>
                        </div>
                        @endif
                        <form action="{{ url('/cart/add/' . $relatedProduct->id) }}" method="POST" class="add-to-cart-form d-inline" 
                              data-product-name="{{ $relatedProduct->name }}"
                              data-product-image="{{ $relatedProduct->image ? asset('storage/'.$relatedProduct->image) : asset('images/products/product-1.jpg') }}"
                              data-product-price="{{ number_format($relatedProduct->display_price ?? $relatedProduct->price, 0, ',', '.') }}">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="product-block-cart-icon">
                                <i class="bi bi-cart-plus text-white fs-4"></i>
                            </button>
                        </form>
                    </div>
                    <div class="product-block-body" style="cursor: pointer;">
                        <h5 class="product-block-title" onclick="window.location.href='{{ url('/products/' . $relatedProduct->id) }}'">{{ $relatedProduct->name }}</h5>
                        <div class="product-block-price-section text-end" onclick="window.location.href='{{ url('/products/' . $relatedProduct->id) }}'">
                            @if($relatedProduct->is_best_seller)
                            <div>
                                <span class="product-block-price-old">{{ number_format($relatedProduct->original_price ?? $relatedProduct->price) }}₫</span>
                                <span class="product-block-price-new">{{ number_format($relatedProduct->display_price) }}₫</span>
                            </div>
                            @else
                            <div><span class="product-block-price-new">{{ number_format($relatedProduct->price) }}₫</span></div>
                            @endif
                        </div>
                        <button class="btn product-block-btn w-100 mt-2" onclick="window.location.href='{{ url('/products/' . $relatedProduct->id) }}'">Xem chi tiết</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
    // Quantity controls
    function increaseQuantity() {
        const input = document.getElementById('quantityInput');
        const currentValue = parseInt(input.value);
        if (currentValue < parseInt(input.max)) {
            input.value = currentValue + 1;
        }
    }

    function decreaseQuantity() {
        const input = document.getElementById('quantityInput');
        const currentValue = parseInt(input.value);
        if (currentValue > parseInt(input.min)) {
            input.value = currentValue - 1;
        }
    }

    // Buy now function
    function buyNow() {
        const form = document.getElementById('addToCartForm');
        const formData = new FormData(form);
        
        // Add to cart via AJAX
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success toast
                if (typeof showCartToast === 'function') {
                    showCartToast('success', {
                        name: form.dataset.productName,
                        image: form.dataset.productImage,
                        price: form.dataset.productPrice
                    });
                }
                // Redirect to checkout after a short delay
                setTimeout(() => {
                    window.location.href = '/checkout';
                }, 500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Show error toast
            if (typeof showCartToast === 'function') {
                showCartToast('error', 'Có lỗi xảy ra. Vui lòng thử lại!');
            }
        });
    }

    // Thumbnail click handler
    document.querySelectorAll('.product-thumbnail').forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            document.querySelectorAll('.product-thumbnail').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const mainImage = document.getElementById('mainImage');
            mainImage.src = this.querySelector('img').src;
        });
    });
</script>
@endsection
