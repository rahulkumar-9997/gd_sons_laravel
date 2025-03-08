$(document).ready(function () {
    $(document).off('click', '.qty-right-plus, .qty-left-minus');
    $(document).on('click', '.qty-right-plus, .qty-left-minus', function (e) {
        e.preventDefault();
        let button = $(this);
        let cartId = button.data('id');
        let url = button.data('url');
        let inputField = button.closest('.input-group').find('.qty-input');
        let currentQuantity = parseInt(inputField.val()) || 0;

        let quantity = button.hasClass('qty-right-plus') ? currentQuantity + 1 : currentQuantity - 1;
        if (quantity < 1) {
            showNotificationAll("warning", "Warning", "Quantity must be at least 1."); 
            return;
        }
        
        if (quantity > 10) {
            showNotificationAll("warning", "Warning", "Quantity cannot exceed 10."); 
            return;
        }
        showSkeletonLoader();
        updateCartQuantity(cartId, quantity, url);
    });

    function updateCartQuantity(cartId, quantity, url) {
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
                    showNotificationAll("success", "Success", "Cart updated successfully."); 
                } else {
                    showNotificationAll("warning", "Warning", response.message || "Something went wrong. Please try again.");
                }
            },
            complete: function () {
                hideSkeletonLoader();
            },
            error: function () {
                showNotificationAll("danger", "Warning", "Something went wrong. Please try again.");
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
        let cartId = button.data('cart-id');
        let url = button.data('url');
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                cart_id: cartId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    let message = response.message || "Product removed from cart.";
                    showNotificationAll("success", '', message);
                    button.closest('.product-box-contain').remove();
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
