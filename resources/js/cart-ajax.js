/**
 * Handle add to cart with AJAX across all pages
 */

(function() {
    'use strict';
    
    // Handle add to cart button clicks
    document.addEventListener('click', function(e) {
        const button = e.target.closest('button[type="submit"]');
        
        if (button) {
            const form = button.closest('form');
            
            if (form && form.classList.contains('add-to-cart-form')) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                
                handleAddToCart(form);
            }
        }
    }, true); // Use capture phase
    
    function handleAddToCart(form) {
        const formData = new FormData(form);
        const productName = form.dataset.productName;
        const productImage = form.dataset.productImage;
        const productPrice = form.dataset.productPrice;
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show toast notification with product info
                if (typeof window.showCartToast === 'function') {
                    window.showCartToast('success', {
                        name: productName,
                        image: productImage,
                        price: productPrice
                    });
                }
                
                // Update cart count badge
                updateCartBadge(data.cart_count);
                
                // Update cart dropdown
                updateCartDropdown(data.cart_html);
            } else {
                alert(data.message || 'Có lỗi xảy ra');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Không thể thêm vào giỏ hàng');
        });
    }
    
    function updateCartBadge(count) {
        const cartBadge = document.getElementById('cart-count-badge');
        if (cartBadge) {
            cartBadge.textContent = count;
            if (count > 0) {
                cartBadge.classList.remove('d-none');
            }
        }
    }
    
    function updateCartDropdown(html) {
        const cartDropdownContent = document.getElementById('cart-dropdown-content');
        if (cartDropdownContent && html) {
            cartDropdownContent.innerHTML = html;
            if (typeof window.attachCartDropdownListeners === 'function') {
                window.attachCartDropdownListeners();
            }
        }
    }
})();
