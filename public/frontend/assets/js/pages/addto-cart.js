$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '.add-to-cart', function () {
        var productId = $(this).data('pid');
        var cartUrl = $(this).data('url');
        var product_mrp = $(this).data('mrp');
        var quantity = $(this).closest('.product-package').find('.qty-input').val();
        var addToCartButton = $(this);
        var originalButtonText = addToCartButton.html();
        addToCartButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Adding...');
        
        $.ajax({
            url: cartUrl,
            method: 'POST',
            data: {
                product_id: productId,
                quantity: quantity,
                product_mrp: product_mrp,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                if (response.success) {
                    $('#cartItem').html(response.cartItems);
                    feather.replace();
                    $("#cart-items").css({
                        "opacity": "1",
                        "visibility": "visible"
                    });
                    setTimeout(function () {
                        $("#cart-items").removeAttr("style");
                    }, 20000);
                    showNotificationAll("success", "", response.message);
                }else{
                    showNotificationAll("danger", "", response.message);
                }
                addToCartButton.prop('disabled', false).html(originalButtonText);
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                var response = xhr.responseJSON || {};
                showNotificationAll("danger", "", response.error || "An unknown error occurred.");
                addToCartButton.prop('disabled', false).html(originalButtonText);
            }
        });
    });
    

       
});
