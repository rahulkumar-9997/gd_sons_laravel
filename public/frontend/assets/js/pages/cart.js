$(document).ready(function() {
    // Handle plus button click
    $('.qty-right-plus').click(function() {
        var cartId = $(this).data('id');
        var quantity = $('input[data-id="' + cartId + '"]').val();
        quantity = parseInt(quantity) + 1; // Increase quantity by 1
        
        var url = $(this).data('url'); // Get the URL from the data-url attribute
        
        updateCart(url, cartId, quantity);
    });

    // Handle minus button click
    $('.qty-left-minus').click(function() {
        var cartId = $(this).data('id');
        var quantity = $('input[data-id="' + cartId + '"]').val();
        quantity = parseInt(quantity) - 1; // Decrease quantity by 1
        
        if (quantity >= 1) {  // Prevent negative quantities
            var url = $(this).data('url'); // Get the URL from the data-url attribute
            
            updateCart(url, cartId, quantity);
        }
    });

    // Function to update the cart via AJAX
    function updateCart(url, cartId, quantity) {
        $.ajax({
            url: url,  // Use the dynamic URL from the button's data-url
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',  // CSRF token for security
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    // Update the quantity in the input field
                    $('input[data-id="' + cartId + '"]').val(quantity);
                    // Optionally, update the cart total or UI
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
