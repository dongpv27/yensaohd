<!-- Mobile & Tablet Product Modal -->
<div class="modal fade" id="mobileProductModal" tabindex="-1" aria-labelledby="mobileProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header border-0 pb-4">
                <h5 class="modal-title fw-bold" id="mobileProductModalLabel">Thông tin sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img id="modalProductImage" src="" alt="" class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                </div>
                <h6 id="modalProductName" class="fw-bold mb-2"></h6>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-danger fw-bold fs-5" id="modalProductPrice"></span>
                    <span id="modalStockStatus" class="badge bg-success"></span>
                </div>
                
                <!-- Quantity Selector -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Số lượng:</label>
                    <div class="input-group" style="max-width: 150px;">
                        <button class="btn btn-outline-secondary" type="button" id="decreaseQuantity">
                            <i class="bi bi-dash"></i>
                        </button>
                        <input type="number" class="form-control text-center" id="modalProductQuantity" value="1" min="1">
                        <button class="btn btn-outline-secondary" type="button" id="increaseQuantity">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="modalAddToCartBtn">
                    <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ hàng
                </button>
            </div>
        </div>
    </div>
</div>
