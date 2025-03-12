$(document).ready(function() {
    // Handle plus button click
    $('.qty-right-plus').click(function() {
        var cartId = $(this).data('id');
        var quantity = $('input[data-id="' + cartId + '"]').val();
        quantity = parseInt(quantity) + 1;
        
        var url = $(this).data('url');
        
        updateCart(url, cartId, quantity);
    });

    // Handle minus button click
    $('.qty-left-minus').click(function() {
        var cartId = $(this).data('id');
        var quantity = $('input[data-id="' + cartId + '"]').val();
        quantity = parseInt(quantity) - 1;
        if (quantity >= 1) { 
            var url = $(this).data('url');
            
            updateCart(url, cartId, quantity);
        }
    });

    // Function to update the cart via AJAX
    function updateCart(url, cartId, quantity) {
        $.ajax({
            url: url, 
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    $('input[data-id="' + cartId + '"]').val(quantity);
                    $('#cart-total').text(response.cart_total);
                } else {
                    alert('Failed to update the cart. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    }
});
