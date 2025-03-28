$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var site_url = $('meta[name="base-url"]').attr('content');
$(document).ready(function () {

    $(document).on('click', 'a[data-uploadimaghe-popup="true"]', function () {
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url
        };
        $("#commanModel .modal-title").html(title);
        $("#commanModel .modal-dialog").addClass('modal-' + size);
        
        $.ajax({
            url: url,
            type: 'get',
            data: data,
            success: function (data) {
                $('#commanModel .render-data').html(data.form);
                $("#commanModel").modal('show');
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
    });

    $(document).on('submit', '#imageStorage', function (event) {
        event.preventDefault();
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
        var formData = new FormData(this);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                submitButton.prop('disabled', false).html('Save changes');
                if (response.status === 'success') {
                    Toastify({
                        text: response.message,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        close: true
                    }).showToast();
                    location.reload();
                }
            },
            error: function(error) {
                submitButton.prop('disabled', false).html('Save changes');
                let errorMessage = 'An unexpected error occurred.';
                if (error.responseJSON) {
                    console.error(error.responseJSON);
                    if (error.responseJSON.message) {
                        errorMessage = error.responseJSON.message;
                    }
                    if (error.responseJSON.errors) {
                        let errorDetails = '<ul>';
                        $.each(error.responseJSON.errors, function(field, messages) {
                            errorDetails += `<li><strong>${field}:</strong> ${messages.join(', ')}</li>`;
                        });
                        errorDetails += '</ul>';
                        errorMessage = errorDetails;
                    }
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
    
    
});

