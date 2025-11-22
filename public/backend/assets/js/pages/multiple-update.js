$(document).ready(function () {
    /**Multiple update form submit */
    $(document).off('submit', '#multipleUpdateProduct').on('submit', '#multipleUpdateProduct', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var submitButton = form.find('button[type="submit"]');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
        $.ajax({
            url: url,
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                submitButton.prop('disabled', false).html('<i class="ti ti-check"></i> Update All');
                Toastify({
                    text: response.message,
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: "bg-success",
                    close: true,
                    onClick: function() {}
                }).showToast();
                const categoryId = $('#category-filter').val();
                const search = $('#product-search').val();
                const criteria = $('#selecte-criteria').val();
                fetchProducts(categoryId, search, criteria, 1);
            },
            error: function(xhr) {
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
                        onClick: function() {}
                    }).showToast();
                    $.each(errors, function(field, messages) {
                        if (field === 'product_id[]') {
                            let input = form.find(`[name="${field}"]`);
                            input.addClass('is-invalid');
                            input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                        } else {
                            let inputName = field.replace('products.', '');
                            let input = form.find(`[name="products[${inputName}]"]`);
                            input.addClass('is-invalid');
                            input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                        }
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
                        onClick: function() {}
                    }).showToast();
                }
            }
        });
    });
    /**Multiple update form submit */
    /**Multiple update Filter */
    $('#category-filter, #product-search').on('change keyup', updateFilters);

    $('#reset-button').on('click', function() {
        $('#category-filter, #product-search').val('');
        $('#reset-button').hide();
        const criteria = $('#selecte-criteria').val();
        fetchProducts('', '', criteria, 1, true);
    });


    $(document).on('click', '.my-pagination a', function(e) {
        e.preventDefault();
        const categoryId = $('#category-filter').val();
        const search = $('#product-search').val();
        const criteria = $('#selecte-criteria').val();
        const page = $(this).attr('href').split('page=')[1];
        fetchProducts(categoryId, search, criteria, page);
    });

    function updateFilters() {
        const categoryId = $('#category-filter').val();
        const search = $('#product-search').val();
        const criteria = $('#selecte-criteria').val();
        if (categoryId || search) {
            $('#reset-button').show();
        } else {
            $('#reset-button').hide();
        }

        fetchProducts(categoryId, search, criteria, 1);
    }

    function fetchProducts(categoryId = '', search = '', criteria = '', page = 1, reset = false) {
        $('#loader').show();
        $.ajax({
            url: routes.filterIndex,
            type: "GET",
            data: {
                category_id: categoryId,
                search: search,
                criteria: criteria,
                page: page,
                reset: reset
            },
            success: function(data) {
                $('#multiple_update').html(data);
                $('#loader').hide();
                if (reset && !criteria) {
                    $('#selecte-criteria').val('');
                }
                initializeQuillEditors();
            },
            error: function() {
                Toastify({
                    text: "An error occurred while filtering products.",
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: "bg-danger",
                    close: true,
                    escapeMarkup: false,
                    onClick: function() {}
                }).showToast();
                $('#loader').hide();
            }
        });
    }

    /**Multiple update Filter */
    /* Volumetric Weight Formula: Length (cm) x Width (cm) x Height (cm) / 5000. */
    $(document).on('input', '.length, .breadth, .height', function () {
        let row = $(this).closest('tr');
        let length = parseFloat(row.find('.length').val()) || 0;
        let breadth = parseFloat(row.find('.breadth').val()) || 0;
        let height = parseFloat(row.find('.height').val()) || 0;
        /* Formula: (L × B × H) / 5000*/
        let volumetricWeight = ((length * breadth * height) / 5000).toFixed(2);
        if (volumetricWeight > 0) {
            row.find('.volumetric-weight-kg').val(volumetricWeight);
        }
    });
 });

 function initializeQuillEditors() {
    document.querySelectorAll('.snow-editor').forEach(function(editor) {
        if (editor.classList.contains('quill-initialized')) return;
        var quill = new Quill(editor, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'font': [] }, { 'size': [] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'script': 'super' }, { 'script': 'sub' }],
                    [{ 'header': [false, 1, 2, 3, 4, 5, 6] }, 'blockquote', 'code-block'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }],
                    ['direction', { 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        var hiddenTextarea = editor.nextElementSibling;
        quill.on('text-change', function () {
            hiddenTextarea.value = quill.root.innerHTML;
        })
        editor.classList.add('quill-initialized'); 
    });
}
