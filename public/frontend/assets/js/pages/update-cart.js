$(document).ready(function () {
    $(document).off('click', '.qty-right-plus-cart, .qty-left-minus-cart').on('click', '.qty-right-plus-cart, .qty-left-minus-cart', function (e) {
        e.preventDefault();
        let button = $(this);
        let row = button.closest('.product-box-contain');
        let inputField = row.find('.qty-input');
        let currentQuantity = parseInt(inputField.val()) || 0;
        let cartId = button.data('id'); 
        let url = button.data('url'); 
        let quantity = button.hasClass('qty-right-plus-cart') ? currentQuantity + 1 : currentQuantity - 1;
        if (quantity > 10) {
            showNotificationAll("warning", "Warning", "Quantity cannot exceed 10.");
            return;
        }
        button.prop('disabled', true);
        showSkeletonLoader();
        updateCartQuantity(cartId, quantity, url, button);
    });
    
    function updateCartQuantity(cartId, quantity, url, button) {
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                cart_id: cartId,
                quantity: quantity,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    $('.cart-items-container').html(response.cart_items_html);
                    showNotificationAll("warning", "Success", response.message);
                } else {
                    showNotificationAll("warning", "Warning", response.message || "Something went wrong. Please try again.");
                }
            },
            complete: function () {
                button.prop('disabled', false);
                hideSkeletonLoader();
            },
            error: function () {
                showNotificationAll("danger", "Warning", "Something went wrong. Please try again.");
                button.prop('disabled', false); 
                hideSkeletonLoader();
            }
        });
    }
    

    
    function showSkeletonLoader() {
        let skeletonHtml = `
            <div class="cart-skeleton">
                <div class="skeleton-cart-item">
                    <div class="skeleton-loader skeleton-image"></div>
                    <div class="skeleton-details">
                        <div class="skeleton-loader skeleton-line"></div>
                        <div class="skeleton-loader skeleton-line short"></div>
                    </div>
                </div>
                <div class="skeleton-cart-item">
                    <div class="skeleton-loader skeleton-image"></div>
                    <div class="skeleton-details">
                        <div class="skeleton-loader skeleton-line"></div>
                        <div class="skeleton-loader skeleton-line short"></div>
                    </div>
                </div>
            </div>`;
        $('.cart-items-container').html(skeletonHtml);
    }

    
    function hideSkeletonLoader() {
        $('.cart-skeleton').remove();
    }
    /**remove cart code */
    $(document).on('click', '.remove-cart', function (e) {
        e.preventDefault();
        let button = $(this);
        let productId = $(this).data('productid');
        let url = button.data('url');
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                productId: productId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    $('.cart-items-container').html(response.cart_items_html);
                    showNotificationAll("success", "Success", response.message);
                } else {
                    let message = response.message || "Failed to remove product from cart.";
                    showNotificationAll("warning", '', message);
                }
            },
            error: function (xhr) {
                let errorMessage = xhr.responseJSON?.message || "Something went wrong.";
                showNotificationAll("danger", "Error", errorMessage);
            }
        });
    });
    
});
