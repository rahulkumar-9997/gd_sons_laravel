$(document).ready(function () {
    var baseUrl = $('meta[name="base-url"]').attr('content');
    /**modal form open code */
    /*$(document).on('click', 'a[data-hsngst-popup="true"]', function () {
        var title = $(this).data('title');
        var product_id = $(this).data('pid');
        var product_name = $(this).data('pname');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url,
            product_id: product_id,
            product_name: product_name,
        };
        $("#commanModel .modal-title").html(title);
        $("#commanModel .modal-dialog").addClass('modal-' + size);
        
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                $('#commanModel .render-data').html(data.form);
                $("#commanModel").modal('show');
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
    });*/

    /**modal form open code */

    $(document).off('submit', '#updatehsngst').on('submit', '#updatehsngst', function (e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var submitButton = form.find('button[type="submit"]');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    
        submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
    
        $.ajax({
            url: url,
            method: 'POST',
            data: form.serialize(),
            success: function (response) {
                submitButton.prop('disabled', false).html('<i class="ti ti-check"></i> Update All');
                Toastify({
                    text: response.message || 'Form submitted successfully!',
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: "bg-success",
                    close: true,
                    onClick: function () { }
                }).showToast();
               // $('#productList').load(location.href + " #productList");
            },
            error: function (xhr) {
                submitButton.prop('disabled', false).html('<i class="ti ti-check"></i> Update All');
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = Object.values(errors).flat().join('<br>');
                    Toastify({
                        text: errorMessages || 'Please correct the errors in the form.',
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-danger",
                        escapeMarkup: false,
                        close: true,
                        onClick: function () { }
                    }).showToast();
                    $.each(errors, function (field, messages) {
                        let inputName = field.replace('products.', '').replace(/\.hsn_code|\.gst_in_per/, '');
                        let input = form.find(`[name="products[${inputName}][${field.includes('hsn_code') ? 'hsn_code' : 'gst_in_per'}]"]`);
                        input.addClass('is-invalid');
                        input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                    });
                } else {
                    let errorMessage = xhr.responseJSON.message || 'An error occurred. Please try again.';
                    Toastify({
                        text: errorMessage,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-danger",
                        close: true,
                        escapeMarkup: false,
                        onClick: function () { }
                    }).showToast();
                }
            }
        });
    });
});

$(document).ready(function () {
    $('#reset-button').hide();
    function fetchFilteredProducts(url = $('#product-update-gst-url').val(), page = 1) {
        let category_id = $('#category-filter').val();
        let search_term = $('#product-search').val();
        url = url + '?page=' + page;
        $.ajax({
            url: url,
            method: "GET",
            data: { category_id, search_term },
            beforeSend: function () {
                $('#loader').show();
                $('#product-list-with-gst-hsn').html('<p>Loading...</p>');
            },
            success: function (response) {
                $('#product-list-with-gst-hsn').html(response.html);
                $('#hsn-gst-pagination').html(response.pagination);
                if (category_id || search_term) {
                    $('#reset-button').show();
                } else {
                    $('#reset-button').hide();
                }
            },
            error: function (xhr) {
                console.error('Error fetching products:', xhr.responseText);
            },
            complete: function () {
                $('#loader').hide();
            }
        });
    }
    $('#category-filter, #product-search').on('input', function() {
        fetchFilteredProducts();
    });

    $('#reset-button').on('click', function () {
        $('#category-filter').val('');
        $('#product-search').val('');
        $(this).hide();
        fetchFilteredProducts();
    });
    $(document).on('click', '#hsn-gst-pagination .pagination a', function (e) {
        e.preventDefault(); 
        let page = $(this).attr('href').split('page=')[1];
        fetchFilteredProducts(undefined, page);
    });
    function checkResetButtonVisibility() {
        let category_id = $('#category-filter').val();
        let search_term = $('#product-search').val();
        if (category_id || search_term) {
            $('#reset-button').show();
        } else {
            $('#reset-button').hide();
        }
    }
    checkResetButtonVisibility();
});

