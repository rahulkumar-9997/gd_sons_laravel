$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var site_url = $('meta[name="base-url"]').attr('content');
$(document).ready(function () {
    $('#commanModel').on('shown.bs.modal', function () {
        initializeQuillEditorsTwo();
    });
    
    
    $(document).on('click', 'a[data-add-primarycategory-popup="true"]', function () {
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
                submitButton.html('Save changes');
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
                    location.reload();
                    
                }
            },
            error: function(xhr, status, error) {
                submitButton.prop('disabled', false);
                submitButton.html('Save changes');
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

    $(document).on('click', 'a[data-edit-primary-category-popup="true" ]', function () {
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var primarycategoryid = $(this).data('primarycategoryid');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url,
            primarycategoryid: primarycategoryid
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

    /**Blog category form submit code */
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
                submitButton.html('Save changes');
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
                    location.reload();
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
    /*Autocomplete for primary category */
    var baseUrl = $('meta[name="base-url"]').attr('content');
    var selectedProductIds = [];
    $(document).on('focus', '.product-autocomplete', function () {
        var $input = $(this);
        var $loader = $(this).siblings('.input-group-text').find('.product-loader');
        var $refreshIcon = $(this).siblings('.input-group-text').find('i');
        $input.removeClass('autocomplete-loading');
        $loader.hide();
        $refreshIcon.show();
        $(this).autocomplete({
            appendTo: $input.closest('.modal'),
            source: function (request, response) {
                $input.addClass('autocomplete-loading');
                $loader.show();
                $refreshIcon.hide();
                $.ajax({
                    url: baseUrl + '/autocomplete/products-whatsapp',
                    data: {
                        query: request.term,
                        page: 1,
                        selected_ids: selectedProductIds || []
                    },
                    success: function (data) {
                        /*alert(JSON.stringify(data));*/
                        $input.removeClass('autocomplete-loading');
                        $loader.hide();
                        $refreshIcon.show();
                        var filteredData = data.filter(function (product) {
                            return !selectedProductIds.includes(product.id.toString());
                        });
                        response(filteredData.map(function (product) {
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
                var row = $(this).closest('.render-autocomplete'); 
                row.find('.product_id').val(ui.item.id);
                selectedProductIds.push(ui.item.id.toString());
            },

        }).autocomplete('instance')._renderItem = function (ul, item) {
            var term = $.ui.autocomplete.escapeRegex($input.val().toLowerCase());
            var matcher = new RegExp('(' + term + ')', 'i');
            var highlightedText = item.label.replace(matcher, '<span style="color: blck; font-weight: bold;">$1</span>');
            return $('<li>')
                .append('<div>' + highlightedText + '</div>')
                .appendTo(ul);
        };
    });
    /*If autocomplete value remove than product id value also remove */
    $(document).on('input', '.product-autocomplete', function () {
        if ($(this).val() === '') {
            var row = $(this).closest('.render-autocomplete'); 
            var productId = row.find('.product_id').val();
            row.find('.product_id').val('');

            selectedProductIds = selectedProductIds.filter(function(id) {
                return id !== productId;
            });
        }
    });
});
   
function initializeQuillEditorsTwo() {
    document.querySelectorAll('.snow-editor').forEach(function(editor) {
        // Check if Quill has already been initialized
        if (!editor.classList.contains('ql-container')) {
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

            // Synchronize the content with the hidden textarea
            var hiddenTextarea = editor.nextElementSibling;
            quill.on('text-change', function() {
                hiddenTextarea.value = quill.root.innerHTML;
            });
        }
    });
}
document.addEventListener('DOMContentLoaded', function() {
    initializeQuillEditorsTwo();
});



/**submut button fixed after scroll */

