$(document).ready(function () {
    /**autocomplete for select product */
    var baseUrl = $('meta[name="base-url"]').attr('content');
    // alert(baseUrl);
    var selectedProductIds = [];
    $(document).on('focus', '.product-autocomplete', function () {
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
                    url: baseUrl + '/autocomplete/products',
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
                var row = $(this).closest('tr .autocompleted');
                row.find('.product_id').val(ui.item.id);
                selectedProductIds.push(ui.item.id.toString());
                /*console.log('Selected hsn : ', ui.item.hsn_code) 
                console.log('Selected gst: ', ui.item.gst_in_per) 
                console.log('Selected Product ID: ', ui.item.id);
                */
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
    /**autocomplete for select product */
    /*Remove product ID if the input is cleared*/
    $(document).on('input', '.product-autocomplete', function () {
        if ($(this).val() === '') {
            var row = $(this).closest('tr .autocompleted'); 
            var productId = row.find('.product_id').val();
            row.find('.product_id').val('');

            selectedProductIds = selectedProductIds.filter(function(id) {
                return id !== productId;
            });
        }
    });
    $(document).on('click', '.add-more-blog-paragraphs', function () {
        var rowCount = $('table tbody tr').length;
        var newRow = `
            <tr class="paragraphstr">
                <td>
                    <input type="text" id="paragraphs_title" name="paragraphs_title[${rowCount}][title]" class="form-control" placeholder="Enter Paragraphs Title">
                </td>
                <td>
                    <label for="blog_img" class="form-label">Select Blog Links</label>
                    <div class="position-relative autocompleted">
                        <div class="input-group">
                            <input type="text" name="product_name[${rowCount}][products][0][name]" class="form-control product-autocomplete">
                            <span class="input-group-text">
                                <i class="ti ti-refresh"></i>
                                <div class="spinner-border spinner-border-sm product-loader" role="status" style="display: none;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </span>
                        </div>
                        <input type="hidden" name="product_id[${rowCount}][products][0][id]" class="product_id">
                    </div>
    
                    <label for="blog_img" class="form-label">Select Blog Links</label>
                    <div class="position-relative autocompleted">
                        <div class="input-group">
                            <input type="text" name="product_name[${rowCount}][products][1][name]" class="form-control product-autocomplete">
                            <span class="input-group-text">
                                <i class="ti ti-refresh"></i>
                                <div class="spinner-border spinner-border-sm product-loader" role="status" style="display: none;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </span>
                        </div>
                        <input type="hidden" name="product_id[${rowCount}][products][1][id]" class="product_id">
                    </div>
                </td>
                <td>
                    <div class="snow-editor" style="height: 150px; width: 100%;"></div>
                    <textarea name="paragraphs_description[${rowCount}]" class="hidden-textarea" style="display:none;"></textarea>
                    
                    <button type="button" class="btn btn-danger remove-row btn-sm">Remove</button>
                </td>
            </tr>
        `;
        
        $('table tbody').append(newRow);
        initializeQuillEditorsAppend();
        initializeProductAutocomplete();
    });
    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
    });

    /**Remove paragraphs */
    $(document).on('click', '.remov-paragraphs', function (event) {
        var url = $(this).data("url");
        var name = $(this).data("name");
        var submitButton = $(this);
        event.preventDefault();
        Swal.fire({
            title: `Are you sure you want to delete this ${name}?`,
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire("Deleted!", "The paragraph has been deleted.", "success");
                            $(event.target).closest('.paragraphstr').remove();
                        } else {
                            Swal.fire("Error", "There was an issue deleting the paragraph.", "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Error", "There was an issue with the request.", "error");
                    },
                    complete: function () {
                        submitButton.prop('disabled', false).html('Remove');
                    }
                });
            }
        });
    });
    /**Remove paragraphs */

});

function initializeQuillEditorsAppend() {
    document.querySelectorAll('.snow-editor').forEach(function (editor) {
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
            quill.on('text-change', function () {
                hiddenTextarea.value = quill.root.innerHTML;
            });
        }
    });
}