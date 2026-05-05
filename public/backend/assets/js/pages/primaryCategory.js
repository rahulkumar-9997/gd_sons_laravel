$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var site_url = $('meta[name="base-url"]').attr('content');
$(document).ready(function () {  

    $(document).off('submit', '#addPrimaryCategory').on('submit', '#addPrimaryCategory', function (event) {
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
                submitButton.prop('disabled', false);
                submitButton.html('Submit');
                if (response.status === 'success') {
                    Toastify({
                        text: response.message,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        close: true,
                        onClick: function () { }
                    }).showToast();
                    window.location.href = response.redirect_url;                    
                }
            },
            error: function(xhr, status, error) {
                submitButton.prop('disabled', false);
                submitButton.html('Submit');
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        var errorElement = $('#' + key + '_error');
                        if (errorElement.length) {
                            errorElement.text(value[0]);
                        }
                        var inputField = $('#' + key);
                        inputField.addClass('is-invalid');
                        inputField.after('<div class="invalid-feedback">' + value[0] + '</div>'); 
                    });
                }
            }
        });
    });

    $(document).off('submit', '#editPrimaryCategory').on('submit', '#editPrimaryCategory', function (event) {
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
                submitButton.prop('disabled', false);
                submitButton.html('Update');
                if (response.status === 'success') {
                    Toastify({
                        text: response.message,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        close: true,
                        onClick: function () { }
                    }).showToast();
                    window.location.href = response.redirect_url;        
                }
            },
            error: function(xhr, status, error) {
                submitButton.prop('disabled', false);
                submitButton.html('Update');
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        var errorElement = $('#' + key + '_error');
                        if (errorElement.length) {
                            errorElement.text(value[0]);
                        }
                        var inputField = $('#' + key);
                        inputField.addClass('is-invalid');
                        inputField.after('<div class="invalid-feedback">' + value[0] + '</div>'); 
                    });
                }
            }
        });
    });

    /**Primary category update status */
	$(document).on('change', '.primaryCategoryStatus', function() {
        var $checkbox = $(this);
        var primaryCategoryId = $checkbox.data('pid');
        var updateUrl = $checkbox.data('url');
        var isActive = $checkbox.is(':checked') ? 1 : 0;
        $('#loader').fadeIn();
        $checkbox.prop('disabled', true);
        
        $.ajax({
            url: updateUrl,
            method: 'POST',
            data: {
                status: isActive,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                if (response.status === 'success') {
                    Toastify({
                        text: response.message,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        close: true,
                    }).showToast();
                }
            },
            error: function(xhr, status, error) {
                $checkbox.prop('checked', !isActive);
                Toastify({
                    text: 'Failed to update status. Please try again.',
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: "bg-danger",
                    close: true,
                }).showToast();
            },
            complete: function() {
                $('#loader').fadeOut();
                $checkbox.prop('disabled', false);
            }
        });
    });
    /**Primary category update status */    
});
