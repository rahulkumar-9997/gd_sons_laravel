$(document).ready(function () {
    $(document).ready(function () {
        $('#group').on('change', function () {
            var selectedGroup = $(this).val();
            var url = new URL(window.location.href);
            if (selectedGroup) {
                url.searchParams.set('group', selectedGroup);
            } else {
                url.searchParams.delete('group');
            }
            window.location.href = url.toString();
        });
    });
    /**What send message form submit* */
    $(document).off('submit', '#groupWhatsAppMessageForm').on('submit', '#groupWhatsAppMessageForm', function (event) {
        event.preventDefault();
        var form = $(this);
        var submitButton = form.find('input[type="submit"]');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        submitButton.prop('disabled', true).val('Sending...');    
        var formData = new FormData(this);  
        $('input[name="customer_id[]"]:checked').each(function() {
            formData.append('customer_id[]', $(this).val());
        });
    
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                submitButton.prop('disabled', false);
                submitButton.val('Submit');
                if (response.status === 'success') {
                    Toastify({
                        text: response.message,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        close: true,
                        onClick: function () {}
                    }).showToast();
                    $('#groupWhatsAppMessageForm')[0].reset();
                }
            },
            error: function(error) {
                submitButton.prop('disabled', false);
                submitButton.val('Submit');
                console.error(error.responseJSON);
                let errorMessage = error.responseJSON?.message || 'An unexpected error occurred.';
                if (error.responseJSON?.errors) {
                    let errorDetails = '<ul>';
                    $.each(error.responseJSON.errors, function(field, messages) {
                        errorDetails += `<li><strong>${field}:</strong> ${messages.join(', ')}</li>`;
                    });
                    errorDetails += '</ul>';
                    errorMessage = errorDetails;
                }
                $('#error-container').html(
                    `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        ${errorMessage}
                    </div>`
                );
            }
        });
    });
    
    
    
    /**What send message form submit* */
});

