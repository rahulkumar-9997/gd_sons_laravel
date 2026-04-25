$(document).off('submit', '#check-delivery-form').on('submit', '#check-delivery-form', function (e) {
    e.preventDefault();

    let form = $(this);
    let submitButton = form.find('.btn-check-delivery');
    let messageBox = $('#pin-message');

    messageBox.html('');

    submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Checking...');

    let formData = new FormData(this);

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,

        success: function(response) {
            submitButton.prop('disabled', false).html('Check');

            if (response.success) {
                $('#courier_partner').html(response.delivery_options);
                let pin = form.find('input[name="pincode"]').val();
                localStorage.setItem('user_pincode', pin);
            } else {
                messageBox.html(response.checkout_sidebar);
            }
        },
        error: function(xhr) {
            submitButton.prop('disabled', false).html('Check');
            let errors = xhr.responseJSON?.errors;
            if (errors && errors.pincode) {
                messageBox.text(errors.pincode[0]);
            } else {
                messageBox.text('Something went wrong');
            }
        }
    });  
    
});
$(document).on('click', '.edit-pincode', function () {
    let url = $(this).data('url');
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            if (res.success) {
                $('#courier_partner').html(res.html);
            }
        }
    });
});