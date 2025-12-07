// Mobile & Tablet Product Modal Handler
(function() {
    'use strict';
    
    // Check if device is mobile or tablet (≤1024px)
    function isMobileDevice() {
        return window.innerWidth <= 1024;
    }
    
    // Initialize mobile product modal
    function initMobileProductModal() {
        // Get all product cards
        const productCards = document.querySelectorAll('.product-block-card');
        
        productCards.forEach(card => {
            // Get clickable elements
            const clickableElements = card.querySelectorAll('.product-clickable, .product-order-btn');
            
            clickableElements.forEach(element => {
                // Remove existing listeners
                element.replaceWith(element.cloneNode(true));
            });
            
            // Re-select after cloning
            const newClickableElements = card.querySelectorAll('.product-clickable, .product-order-btn');
            
            newClickableElements.forEach(element => {
                element.addEventListener('click', function(e) {
                    if (isMobileDevice()) {
                        // Mobile/Tablet: Show modal
                        e.preventDefault();
                        e.stopPropagation();
                        
                        // Get product data from card
                        const productId = card.dataset.productId;
                        const productName = card.dataset.productName;
                        const productPrice = card.dataset.productPrice;
                        const productImage = card.dataset.productImage;
                        const productQuantity = card.dataset.productQuantity;
                        
                        // Show modal
                        showProductModal({
                            id: productId,
                            name: productName,
                            price: productPrice,
                            image: productImage,
                            quantity: productQuantity
                        });
                    } else {
                        // Desktop: Redirect to product page
                        const productId = card.dataset.productId;
                        if (productId) {
                            window.location.href = `/products/${productId}`;
                        }
                    }
                });
            });
            
            // Keep cart icon working normally
            const cartForm = card.querySelector('.add-to-cart-form');
            if (cartForm) {
                cartForm.addEventListener('submit', function(e) {
                    e.stopPropagation(); // Prevent triggering modal
                });
            }
        });
    }
    
    // Show product modal
    function showProductModal(product) {
        const modal = document.getElementById('mobileProductModal');
        if (!modal) return;
        
        // Update modal content
        document.getElementById('modalProductImage').src = product.image;
        document.getElementById('modalProductName').textContent = product.name;
        document.getElementById('modalProductPrice').textContent = new Intl.NumberFormat('vi-VN').format(product.price) + '₫';
        
        // Set quantity limits
        const quantityInput = document.getElementById('modalProductQuantity');
        quantityInput.value = 1;
        quantityInput.max = product.quantity;
        
        // Update stock status
        const stockBadge = document.getElementById('modalStockStatus');
        const addToCartBtn = document.getElementById('modalAddToCartBtn');
        const decreaseBtn = document.getElementById('decreaseQuantity');
        const increaseBtn = document.getElementById('increaseQuantity');
        
        if (product.quantity > 0) {
            stockBadge.className = 'badge bg-success';
            stockBadge.textContent = `Còn ${product.quantity} sản phẩm`;
            
            // Enable quantity controls and button
            quantityInput.disabled = false;
            decreaseBtn.disabled = false;
            increaseBtn.disabled = false;
            addToCartBtn.disabled = false;
            addToCartBtn.classList.remove('btn-secondary');
            addToCartBtn.classList.add('btn-primary');
            addToCartBtn.innerHTML = '<i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ hàng';
        } else {
            stockBadge.className = 'badge bg-danger';
            stockBadge.textContent = 'Hết hàng';
            
            // Disable quantity controls and button
            quantityInput.disabled = true;
            decreaseBtn.disabled = true;
            increaseBtn.disabled = true;
            addToCartBtn.disabled = true;
            addToCartBtn.classList.remove('btn-primary');
            addToCartBtn.classList.add('btn-secondary');
            addToCartBtn.innerHTML = '<i class="bi bi-x-circle me-2"></i>Hết hàng';
        }
        
        // Store product ID for add to cart
        addToCartBtn.dataset.productId = product.id;
        addToCartBtn.dataset.productName = product.name;
        addToCartBtn.dataset.productImage = product.image;
        addToCartBtn.dataset.productPrice = new Intl.NumberFormat('vi-VN').format(product.price);
        addToCartBtn.dataset.productQuantity = product.quantity;
        
        // Show modal
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }
    
    // Handle quantity change
    function setupQuantityControls() {
        const decreaseBtn = document.getElementById('decreaseQuantity');
        const increaseBtn = document.getElementById('increaseQuantity');
        const quantityInput = document.getElementById('modalProductQuantity');
        
        if (decreaseBtn) {
            decreaseBtn.addEventListener('click', function() {
                const currentValue = parseInt(quantityInput.value) || 1;
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });
        }
        
        if (increaseBtn) {
            increaseBtn.addEventListener('click', function() {
                const currentValue = parseInt(quantityInput.value) || 1;
                const maxValue = parseInt(quantityInput.max) || 999;
                if (currentValue < maxValue) {
                    quantityInput.value = currentValue + 1;
                } else {
                    // Show warning if trying to exceed stock
                    showQuantityWarning(maxValue);
                }
            });
        }
        
        // Handle manual input
        if (quantityInput) {
            quantityInput.addEventListener('input', function() {
                validateQuantityInput(this);
            });
            
            quantityInput.addEventListener('blur', function() {
                normalizeQuantityInput(this);
            });
            
            // Prevent non-numeric input
            quantityInput.addEventListener('keypress', function(e) {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });
        }
    }
    
    // Validate quantity input in real-time
    function validateQuantityInput(input) {
        let value = input.value.replace(/[^0-9]/g, ''); // Remove non-numeric
        
        if (value === '' || value === '0') {
            input.value = value;
            return;
        }
        
        const numValue = parseInt(value);
        const maxValue = parseInt(input.max) || 999;
        
        if (numValue > maxValue) {
            input.value = maxValue;
            showQuantityWarning(maxValue);
        } else {
            input.value = numValue;
        }
    }
    
    // Normalize quantity input on blur
    function normalizeQuantityInput(input) {
        let value = parseInt(input.value);
        
        if (isNaN(value) || value < 1) {
            input.value = 1;
        }
        
        const maxValue = parseInt(input.max) || 999;
        if (value > maxValue) {
            input.value = maxValue;
        }
    }
    
    // Show quantity warning
    function showQuantityWarning(maxQuantity) {
        const existingWarning = document.getElementById('quantityWarning');
        if (existingWarning) {
            existingWarning.remove();
        }
        
        const warningDiv = document.createElement('div');
        warningDiv.id = 'quantityWarning';
        warningDiv.className = 'alert alert-warning alert-dismissible fade show mt-2 mb-0';
        warningDiv.style.cssText = 'font-size: 0.85rem; padding: 0.5rem 0.75rem;';
        warningDiv.innerHTML = `
            <i class="bi bi-exclamation-triangle me-1"></i>
            Chỉ còn ${maxQuantity} sản phẩm trong kho
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.7rem; padding: 0.4rem;"></button>
        `;
        
        const quantityContainer = document.getElementById('modalProductQuantity').parentElement.parentElement;
        quantityContainer.appendChild(warningDiv);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (warningDiv && warningDiv.parentElement) {
                warningDiv.remove();
            }
        }, 3000);
    }
    
    // Handle add to cart from modal
    function setupModalAddToCart() {
        const addToCartBtn = document.getElementById('modalAddToCartBtn');
        
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', function() {
                const productQuantity = parseInt(this.dataset.productQuantity || 0);
                
                // Check if product is out of stock
                if (productQuantity <= 0) {
                    // Show out of stock toast
                    if (typeof showCartToast === 'function') {
                        showCartToast('error', 'Sản phẩm đã hết hàng');
                    }
                    return;
                }
                
                const productId = this.dataset.productId;
                const productName = this.dataset.productName;
                const productImage = this.dataset.productImage;
                const productPrice = this.dataset.productPrice;
                const quantityInput = document.getElementById('modalProductQuantity');
                
                // Validate quantity before submit
                let quantity = parseInt(quantityInput.value);
                const maxQuantity = parseInt(quantityInput.max);
                
                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1;
                    quantityInput.value = 1;
                }
                
                if (quantity > maxQuantity) {
                    quantity = maxQuantity;
                    quantityInput.value = maxQuantity;
                    showQuantityWarning(maxQuantity);
                    return;
                }
                
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // Create form data
                const formData = new FormData();
                formData.append('_token', csrfToken);
                formData.append('quantity', quantity);
                
                // Show loading state
                addToCartBtn.disabled = true;
                addToCartBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang thêm...';
                
                // Send AJAX request
                fetch(`/cart/add/${productId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success toast
                        if (typeof showCartToast === 'function') {
                            showCartToast('success', {
                                name: productName,
                                image: productImage,
                                price: productPrice
                            });
                        }
                        
                        // Update cart count badge
                        const cartBadge = document.getElementById('cart-count-badge');
                        if (cartBadge && data.cart_count) {
                            cartBadge.textContent = data.cart_count;
                            cartBadge.classList.remove('d-none');
                        }
                        
                        // Update cart dropdown HTML
                        const cartDropdownContent = document.getElementById('cart-dropdown-content');
                        if (cartDropdownContent && data.cart_html) {
                            cartDropdownContent.innerHTML = data.cart_html;
                        }
                        
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('mobileProductModal'));
                        if (modal) {
                            modal.hide();
                        }
                    } else {
                        // Show error toast
                        if (typeof showCartToast === 'function') {
                            showCartToast('error', data.message || 'Có lỗi xảy ra');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof showCartToast === 'function') {
                        showCartToast('error', 'Có lỗi xảy ra khi thêm vào giỏ hàng');
                    }
                })
                .finally(() => {
                    // Reset button state
                    addToCartBtn.disabled = false;
                    addToCartBtn.innerHTML = '<i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ hàng';
                });
            });
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        initMobileProductModal();
        setupQuantityControls();
        setupModalAddToCart();
        
        // Re-initialize when window is resized
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                initMobileProductModal();
            }, 250);
        });
    });
})();
