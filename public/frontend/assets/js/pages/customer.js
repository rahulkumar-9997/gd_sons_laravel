$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('change', '.profileupdate', function() {
        var input = this;
        var customerId = $(this).data('cuid');
        var uploadUrl = $(this).data('url');
        var formData = new FormData();
        formData.append('image', input.files[0]);
        formData.append('customer_id', customerId);
        var imageContainer = $(input).closest('.profile-image');
        var spinner = imageContainer.find('.spinner');
        spinner.show();
        $.ajax({
            url: uploadUrl,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                spinner.show();
            },
            success: function(response) {
                spinner.hide(); 
                if (response.success) {
                    $('.update_img').attr('src', response.imageUrl); 
                    showNotificationAll('success', 'Success', response.message || 'Profile image uploaded successfully!');
                } else {
                    
                    showNotificationAll('danger', 'Error', response.message || 'Failed to upload image');
                }
            },
            error: function(xhr, status, error) {
                spinner.hide();
                showNotificationAll('danger', 'Error', xhr.responseJSON.message || 'An error occurred during the upload.');
            }
        });
    });
    
    
    
        
});


