$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var baseUrl = $('meta[name="base-url"]').attr('content');
$(document).ready(function () {
    $(document).on('click', '.generate-ai-review', function () {
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url
        };
        
        $("#commanModel .modal-title").html(title);
        $("#commanModel .modal-dialog").removeClass('modal-sm modal-md modal-lg modal-xl').addClass('modal-' + size);
        $('#commanModel .render-data').html(`
            <div class="modal-body text-center p-5">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5>Generating AI Reviews...</h5>
                <p class="text-muted">This may take a few moments</p>
            </div>
        `);        
        $("#commanModel").modal('show');        
        $.ajax({
            url: url,
            type: 'get',
            data: data,
            success: function (data) {
                $('#commanModel .render-data').html(data.form);
            },
            error: function (xhr) {
                let errorMsg = 'An error occurred. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.form) {
                    $('#commanModel .render-data').html(xhr.responseJSON.form);
                } else {
                    $('#commanModel .render-data').html(`
                        <div class="modal-body">
                            <div class="alert alert-danger">${errorMsg}</div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    `);
                }
            }
        });
    });

    
    $(document).on('click', '.regenerate-all-reviews', function () {
        var productId = $(this).data('product-id');
        var customPrompt = $('#customPrompt').val();
        var button = $(this);        
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status"></span> Regenerating...');        
        $.ajax({
            url: baseUrl + '/regenerate-ai-review',
            type: 'POST',
            data: {
                product_id: productId,
                custom_prompt: customPrompt
            },
            success: function(response) {
                $('#commanModel .render-data').html(response.form);
            },
            error: function(xhr) {
                button.prop('disabled', false).html('<i class="ti ti-refresh"></i> Regenerate All');
                if (xhr.responseJSON && xhr.responseJSON.form) {
                    $('#commanModel .render-data').html(xhr.responseJSON.form);
                } else {
                    alert('Failed to regenerate reviews. Please try again.');
                }
            }
        });
    });

    
    $(document).on('click', '.regenerate-with-prompt', function () {
        var productId = $(this).data('product-id');
        var customPrompt = $('#customPrompt').val();
        var button = $(this);
        
        if (!productId) {
            productId = $('input[name="reviews[0][product_id]"]').val();
        }        
        if (!productId) {
            alert('Product ID not found');
            return;
        }        
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing...');        
        $.ajax({
            url: baseUrl + '/regenerate-ai-review',
            type: 'POST',
            data: {
                product_id: productId,
                custom_prompt: customPrompt
            },
            success: function(response) {
                $('#commanModel .render-data').html(response.form);
            },
            error: function(xhr) {
                button.prop('disabled', false).html('<i class="ti ti-refresh"></i> Regenerate with Custom Prompt');
                if (xhr.responseJSON && xhr.responseJSON.form) {
                    $('#commanModel .render-data').html(xhr.responseJSON.form);
                } else {
                    alert('Failed to regenerate reviews. Please try again.');
                }
            }
        });
    });

    
    $(document).on('submit', '#saveReviewData', function (event) {
        event.preventDefault();        
        var form = $(this);
        var submitButton = form.find('.save-all-reviews');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        $('#formError').addClass('d-none').html('');        
        submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status"></span> Saving...');        
        var formData = new FormData(this);        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                submitButton.prop('disabled', false).html('<i class="ti ti-device-floppy"></i> Save All Reviews');                
                if (response.status === 'success') {
                    form[0].reset();
                    $('#commanModel').modal('hide');                    
                    Toastify({
                        text: response.message,
                        duration: 5000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        close: true
                    }).showToast();
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            },
            error: function(error) {
                submitButton.prop('disabled', false).html('<i class="ti ti-device-floppy"></i> Save All Reviews');                
                let errorMessage = 'An unexpected error occurred.';                
                if (error.responseJSON) {
                    if (error.responseJSON.message) {
                        errorMessage = error.responseJSON.message;
                    }                    
                    if (error.responseJSON.errors) {
                        let errorDetails = '<ul class="mb-0">';
                        $.each(error.responseJSON.errors, function(field, messages) {
                            errorDetails += `<li><strong>${field}:</strong> ${messages.join(', ')}</li>`;
                        });
                        errorDetails += '</ul>';
                        errorMessage = errorDetails;
                        $.each(error.responseJSON.errors, function(field, messages) {
                            let fieldName = field.replace('reviews.', '').replace(/\./g, '');
                            $(`[name="${field}"]`).addClass('is-invalid');
                        });
                    }
                }    
                $('#formError').removeClass('d-none').html(errorMessage);
                $('html, body').animate({
                    scrollTop: $('#formError').offset().top - 100
                }, 500);
            }
        });
    });
});