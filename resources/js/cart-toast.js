// Toast notification function for cart
function showCartToast(type, data) {
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

// Handle add to cart forms with AJAX using event delegation
function initializeCartForms() {
    // Remove old event listener if exists
    if (window._cartFormHandler) {
        document.removeEventListener('submit', window._cartFormHandler);
    }
    
    // Create new handler
    window._cartFormHandler = function(e) {
        // Check if the submitted form is an add-to-cart form
        if (e.target.classList.contains('add-to-cart-form')) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Add to cart form submitted via AJAX');
            
            const form = e.target;
            const formData = new FormData(form);
            const productName = form.dataset.productName;
            const productImage = form.dataset.productImage;
            const productPrice = form.dataset.productPrice;
            
            handleCartFormSubmit(form, formData, productName, productImage, productPrice);
        }
    };
    
    // Attach event listener to document
    document.addEventListener('submit', window._cartFormHandler);
}

function handleCartFormSubmit(form, formData, productName, productImage, productPrice) {
    
    fetch(form.action, {
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
            showCartToast('success', {
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
            showCartToast('error', data.message || 'Có lỗi xảy ra');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showCartToast('error', 'Không thể thêm vào giỏ hàng');
    });
}

// Make functions globally available first
window.showCartToast = showCartToast;
window.initializeCartForms = initializeCartForms;

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeCartForms);
} else {
    // DOM is already ready
    initializeCartForms();
}
