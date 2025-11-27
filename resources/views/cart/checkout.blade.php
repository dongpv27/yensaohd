@extends('layouts.master')

@section('content')
<div class="container my-5">
    <!-- Progress Breadcrumb -->
    <div class="checkout-progress">
        <ul class="progress-steps">
            <div class="progress-line" style="width: 50%;\"></div>
            
            <li class="progress-step completed">
                <div class="progress-step-circle">
                    <i class="bi bi-check-lg"></i>
                </div>
                <div class="progress-step-label">Giỏ hàng</div>
            </li>
            
            <li class="progress-step active">
                <div class="progress-step-circle">
                    <i class="bi bi-credit-card"></i>
                </div>
                <div class="progress-step-label">Thanh toán</div>
            </li>
            
            <li class="progress-step">
                <div class="progress-step-circle">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="progress-step-label">Hoàn thành</div>
            </li>
        </ul>
    </div>
    
    <div class="checkout-wrapper">
        <!-- Coupon Section -->
        <div class="coupon-section">
            <p class="mb-0">
                <i class="bi bi-tag-fill"></i> 
                Bạn có mã ưu đãi? 
                <a href="#" data-bs-toggle="collapse" data-bs-target="#couponCollapse">Ấn vào đây để nhập mã</a>
            </p>
            <div class="collapse mt-3" id="couponCollapse">
                <div class="coupon-input-group">
                    <input type="text" class="form-control" placeholder="Mã ưu đãi">
                    <button class="btn btn-apply">Áp dụng</button>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Payment Information -->
            <div class="col-lg-7">
                <div class="checkout-section">
                    <h3 class="section-heading">THÔNG TIN THANH TOÁN</h3>
                    
                    <form action="/checkout" method="POST" id="checkoutForm">
                        @csrf
                        
                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone and Email -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Địa chỉ email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- City and District -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                <select class="form-select @error('city') is-invalid @enderror" id="city" name="city" required>
                                    <option value="">Chọn tỉnh/thành phố</option>
                                </select>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="district" class="form-label">Quận/Huyện <span class="text-danger">*</span></label>
                                <select class="form-select @error('district') is-invalid @enderror" id="district" name="district" required>
                                    <option value="">Chọn quận huyện</option>
                                </select>
                                @error('district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Ward and Address -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ward" class="form-label">Xã/Phường <span class="text-danger">*</span></label>
                                <select class="form-select @error('ward') is-invalid @enderror" id="ward" name="ward" required>
                                    <option value="">Chọn xã/phường</option>
                                </select>
                                @error('ward')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" placeholder="Ví dụ: Số 20, ngõ 90" required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <!-- Order Notes -->
                        <div class="mb-3">
                            <label for="notes" class="form-label">Ghi chú đơn hàng (tùy chọn)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn.">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="col-lg-5">
                <div class="order-summary">
                    <h3 class="summary-heading">ĐƠN HÀNG CỦA BẠN</h3>
                    
                    <div class="summary-table">
                        <div class="summary-header">
                            <span>SẢN PHẨM</span>
                            <span>TẠM TÍNH</span>
                        </div>

                        @foreach($cart as $item)
                        <div class="summary-item">
                            <div class="item-name">
                                {{ $item['name'] }} <span class="item-qty">× {{ $item['quantity'] }}</span>
                            </div>
                            <div class="item-price">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}₫</div>
                        </div>
                        @endforeach

                        <div class="summary-row">
                            <span class="summary-label">Tạm tính</span>
                            <span class="summary-value">{{ number_format($total, 0, ',', '.') }}₫</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Vận chuyển</span>
                            <span class="summary-value shipping-free">Giao hàng miễn phí</span>
                        </div>

                        <div class="summary-total">
                            <span class="total-label">Tổng</span>
                            <span class="total-value">{{ number_format($total, 0, ',', '.') }}₫</span>
                        </div>
                    </div>

                    <div class="payment-method">
                        <h4 class="payment-heading">PHƯƠNG THỨC THANH TOÁN</h4>
                        
                        <!-- COD Payment -->
                        <div class="payment-option">
                            <div class="form-check">
                                <input class="form-check-input @error('payment_method') is-invalid @enderror" type="radio" name="payment_method" id="paymentCOD" value="cod" {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }} form="checkoutForm">
                                <label class="form-check-label payment-label" for="paymentCOD">
                                    <i class="bi bi-cash-coin text-success me-2"></i>
                                    <strong>Thanh toán khi nhận hàng (COD)</strong>
                                </label>
                            </div>
                            <div class="payment-description {{ old('payment_method', 'cod') == 'cod' ? '' : 'd-none' }}" id="codDescription">
                                <p class="mb-0">
                                    Thanh toán bằng tiền mặt khi nhận hàng. Bạn có thể kiểm tra hàng trước khi thanh toán.
                                </p>
                            </div>
                        </div>

                        <!-- Online Payment -->
                        <div class="payment-option">
                            <div class="form-check">
                                <input class="form-check-input @error('payment_method') is-invalid @enderror" type="radio" name="payment_method" id="paymentOnline" value="online" {{ old('payment_method') == 'online' ? 'checked' : '' }} form="checkoutForm">
                                <label class="form-check-label payment-label" for="paymentOnline">
                                    <i class="bi bi-credit-card text-primary me-2"></i>
                                    <strong>Thanh toán trực tuyến</strong>
                                </label>
                            </div>
                            <div class="payment-description {{ old('payment_method') == 'online' ? '' : 'd-none' }}" id="onlineDescription">
                                <p class="mb-3">Chọn phương thức thanh toán:</p>
                                
                                <!-- Bank Transfer -->
                                <div class="form-check mb-2">
                                    <input class="form-check-input @error('online_method') is-invalid @enderror" type="radio" name="online_method" id="bankTransfer" value="bank" {{ old('online_method') == 'bank' ? 'checked' : '' }} form="checkoutForm">
                                    <label class="form-check-label" for="bankTransfer">
                                        <i class="bi bi-bank text-info me-2"></i>
                                        Chuyển khoản ngân hàng
                                    </label>
                                </div>

                                <!-- MoMo -->
                                <div class="form-check mb-2">
                                    <input class="form-check-input @error('online_method') is-invalid @enderror" type="radio" name="online_method" id="momoPayment" value="vnpay" {{ old('online_method') == 'vnpay' ? 'checked' : '' }} form="checkoutForm">
                                    <label class="form-check-label d-flex align-items-center" for="momoPayment">
                                        <img src="{{ asset('images/logo/momo.png') }}" alt="MoMo" style="height: 20px;" class="me-2">
                                        <span style="color: #A50064; font-weight: 600;">MoMo</span>
                                    </label>
                                </div>
                                @error('online_method')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            @error('payment_method')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" form="checkoutForm" class="btn-place-order">
                            ĐẶT HÀNG
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const citySelect = document.getElementById('city');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');

    // API endpoint
    const API_URL = 'https://provinces.open-api.vn/api/v1';
    
    // Store data
    let provinces = [];
    let districts = [];
    let wards = [];

    // Restore old values
    const oldCity = "{{ old('city') }}";
    const oldDistrict = "{{ old('district') }}";
    const oldWard = "{{ old('ward') }}";

    // Load provinces on page load
    async function loadProvinces() {
        try {
            const response = await fetch(`${API_URL}/p/`);
            provinces = await response.json();
            
            // Populate city select
            provinces.forEach(province => {
                const option = document.createElement('option');
                option.value = province.name;
                option.dataset.code = province.code;
                option.textContent = province.name;
                option.selected = province.name === oldCity;
                citySelect.appendChild(option);
            });

            // Load districts if old city exists
            if (oldCity) {
                const selectedProvince = provinces.find(p => p.name === oldCity);
                if (selectedProvince) {
                    await loadDistricts(selectedProvince.code);
                }
            }
        } catch (error) {
            console.error('Error loading provinces:', error);
        }
    }

    // Load districts based on province
    async function loadDistricts(provinceCode) {
        try {
            districtSelect.disabled = true;
            wardSelect.disabled = true;
            districtSelect.innerHTML = '<option value="">Đang tải...</option>';
            wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>';
            
            const response = await fetch(`${API_URL}/p/${provinceCode}?depth=2`);
            const data = await response.json();
            districts = data.districts;
            
            // Build all options first
            const fragment = document.createDocumentFragment();
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Chọn quận huyện';
            fragment.appendChild(defaultOption);
            
            districts.forEach(district => {
                const option = document.createElement('option');
                option.value = district.name;
                option.dataset.code = district.code;
                option.textContent = district.name;
                option.selected = district.name === oldDistrict;
                fragment.appendChild(option);
            });
            
            // Replace all at once
            districtSelect.innerHTML = '';
            districtSelect.appendChild(fragment);
            districtSelect.disabled = false;

            // Load wards if old district exists
            if (oldDistrict) {
                const selectedDistrict = districts.find(d => d.name === oldDistrict);
                if (selectedDistrict) {
                    await loadWards(selectedDistrict.code);
                }
            }
        } catch (error) {
            console.error('Error loading districts:', error);
            districtSelect.innerHTML = '<option value="">Lỗi tải dữ liệu</option>';
            districtSelect.disabled = false;
        }
    }

    // Load wards based on district
    async function loadWards(districtCode) {
        try {
            wardSelect.disabled = true;
            wardSelect.innerHTML = '<option value="">Đang tải...</option>';
            
            const response = await fetch(`${API_URL}/d/${districtCode}?depth=2`);
            const data = await response.json();
            wards = data.wards;
            
            // Build all options first
            const fragment = document.createDocumentFragment();
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Chọn xã/phường';
            fragment.appendChild(defaultOption);
            
            wards.forEach(ward => {
                const option = document.createElement('option');
                option.value = ward.name;
                option.textContent = ward.name;
                option.selected = ward.name === oldWard;
                fragment.appendChild(option);
            });
            
            // Replace all at once
            wardSelect.innerHTML = '';
            wardSelect.appendChild(fragment);
            wardSelect.disabled = false;
        } catch (error) {
            console.error('Error loading wards:', error);
            wardSelect.innerHTML = '<option value="">Lỗi tải dữ liệu</option>';
            wardSelect.disabled = false;
        }
    }

    // Event listeners
    citySelect.addEventListener('change', async function() {
        const selectedOption = this.options[this.selectedIndex];
        const provinceCode = selectedOption.dataset.code;
        
        districtSelect.innerHTML = '<option value="">Chọn quận huyện</option>';
        wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>';
        districtSelect.disabled = true;
        wardSelect.disabled = true;
        
        if (provinceCode) {
            await loadDistricts(provinceCode);
            districtSelect.disabled = false;
        }
    });

    districtSelect.addEventListener('change', async function() {
        const selectedOption = this.options[this.selectedIndex];
        const districtCode = selectedOption.dataset.code;
        
        wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>';
        wardSelect.disabled = true;
        
        if (districtCode) {
            await loadWards(districtCode);
            wardSelect.disabled = false;
        }
    });

    // Initialize
    loadProvinces();

    // Payment method handling
    const paymentCOD = document.getElementById('paymentCOD');
    const paymentOnline = document.getElementById('paymentOnline');
    const codDescription = document.getElementById('codDescription');
    const onlineDescription = document.getElementById('onlineDescription');

    paymentCOD.addEventListener('change', function() {
        if (this.checked) {
            codDescription.classList.remove('d-none');
            onlineDescription.classList.add('d-none');
        }
    });

    paymentOnline.addEventListener('change', function() {
        if (this.checked) {
            codDescription.classList.add('d-none');
            onlineDescription.classList.remove('d-none');
        }
    });

</script>
@endsection
