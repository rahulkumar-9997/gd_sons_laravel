$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var baseUrl = $('meta[name="base-url"]').attr('content');
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
                    form[0].reset();
                    $('#commanModel').modal('hide');
                    $('.storage-img-list').html(response.storageImages);
                    Toastify({
                        text: response.message,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        close: true
                    }).showToast();
                    
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
    /*storage product autocomplete */
    $(document).on('focus', '.storage-product-autocomplete', function () {
        var $input = $(this);
        var $loader = $(this).siblings('.input-group-text').find('.product-loader'); 
        var $refreshIcon = $(this).siblings('.input-group-text').find('i'); 
    
        $input.removeClass('autocomplete-loading');
        $loader.hide(); 
        $refreshIcon.show(); 
    
        $(this).autocomplete({
            source: function (request, response) {
                $input.addClass('autocomplete-loading');
                $loader.show(); 
                $refreshIcon.hide(); 
    
                $.ajax({
                    url: baseUrl + '/autocomplete/products-whatsapp',
                    data: {
                        query: request.term,
                        page: 1,
                    },
                    success: function (data) {
                        $input.removeClass('autocomplete-loading');
                        $loader.hide();
                        $refreshIcon.show();
                       
                        response(data.map(function (product) {
                            return {
                                label: product.title,
                                value: product.title,
                                id: product.id,                                
                            };
                        }));
                    },
                    error: function () {
                        console.error('Error fetching autocomplete data');
                        $input.removeClass('autocomplete-loading');
                        $loader.hide();
                        $refreshIcon.show();
                    }
                });
            },
            minLength: 0,  
            select: function (event, ui) {
                var row = $(this).closest('.fixed-submit-container'); 
                row.find('.product_id').val(ui.item.id);
            },
            
        }).autocomplete('instance')._renderItem = function (ul, item) {
            var term = $.ui.autocomplete.escapeRegex($input.val().toLowerCase());
            var matcher = new RegExp('(' + term + ')', 'i');
            var highlightedText = item.label.replace(matcher, '<span style="color: black; font-weight: bold;">$1</span>');
            return $('<li>')
                .append('<div>' + highlightedText + '</div>')
                .appendTo(ul);
        };
    });
    
    /*storage product autocomplete */
    /*Remove product ID if the input is cleared*/
    $(document).on('input', '.storage-product-autocomplete', function () {
        if ($(this).val() === '') {
            var row = $(this).closest('.fixed-submit-container'); 
            var productId = row.find('.product_id').val();
            row.find('.product_id').val('');

        }
    });
    /**mapped image to product form submit */
    $(document).on('submit', '#imageMappedToProduct', function (event) {
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
                submitButton.prop('disabled', false).html('Map Selected Images to Product');
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
    
                $('#error-container-form').html(
                    `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        ${errorMessage}
                    </div>`
                );
            }
        });
    });
    
    /**mapped image to product form submit */
    /**storage image delete */
    $(document).on('click', '.show_confirm', function (event) {
        event.preventDefault();
        var id = $(this).data('id'); 
        var deleteUrl = $(this).data('url');
        var element = $(this);
        Swal.fire({
            title: "Are you sure to delete this image?",
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        Swal.fire("Deleted!", response.message, "success");
                        $('.storage-img-list').html(response.storageImages);
                    },
                    error: function(xhr) {
                        Swal.fire("Error!", "Failed to delete. Try again.", "error");
                    }
                });
            }
        });
    });
    /**storage image delete */
    
});

