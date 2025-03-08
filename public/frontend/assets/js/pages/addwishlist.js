
$(document).ready(function () {
    $(document).on('click', '.addwishlist', function () {
        let productId = $(this).data('pid');
        let customerId = $(this).data('cuid');
        let url = $(this).data('url');
        let icon = $(this).find('.heart-icon');
    
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product_id: productId,
                customer_id: customerId
            },
            success: function (response) {
                if (response.status.trim() === 'success') {
                    icon.addClass('filled');
                } else if (response.status.trim() === 'removed') {
                    icon.removeClass('filled');
                    
                }
                showNotificationAll("success", "", response.message);
            },
            error: function () {
                showNotificationAll("danger", "", "An error occurred while updating the wishlist.");
            }
        });
    });
    $(document).on('click', '.wishlist_remove', function (e) {
        e.preventDefault();
    
        const wishlist_id = $(this).data('wishlist-id');
        const url = $(this).data('url');
        const button = $(this);
        $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                wishlistid: wishlist_id
            },
            success: function (response) {
                if (response.status === 'success') {
                    button.closest('.col-xxl-3').remove();
                    showNotificationAll("success", "", response.message);
                    /*if ($('.product-box-3').length === 0) {
                        $('.row').html('<div class="col-xxl-12 col-lg-12 col-md-12 col-sm-12"><p>Your wishlist is empty.</p></div>');
                    }*/
                } else {
                    showNotificationAll("danger", "", response.message);
                }
            },
            error: function () {
                alert('An error occurred. Please try again.');
            }
        });
    });
    
});