
$(document).ready(function () {
    $(document).on('click', '.quick-view', function (e) {
        e.preventDefault();
        var $button = $(this);
        var originalContent = $button.html();
        $button.html('<i class="fas fa-spinner fa-spin"></i>');
        var productId = $button.data('product-id');
        var url = $button.data('url');

        $.ajax({
            url: url,
            type: 'get',
            data: {
                product_id: productId,
            },
            success: function (response) {
                $button.html(originalContent);
                $('#QuickModalView .render-data').html(response.quickviewmodal);
                $("#QuickModalView").modal('show');
            },
            error: function () {
                $button.html(originalContent);
                showNotificationAll("danger", "", "Error.");
            }
        });
    });
    
    
});

