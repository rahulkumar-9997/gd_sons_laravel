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
    $('.primaryCategoryStatus').change(function() {
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
   
function initializeQuillEditorsTwo() {
    document.querySelectorAll('.snow-editor').forEach(function(editorContainer) {
        if (editorContainer.classList.contains('ql-container')) {
            return;
        }
        const wrapper = document.createElement('div');
        wrapper.className = 'quill-editor-wrapper';
        editorContainer.parentNode.insertBefore(wrapper, editorContainer);
        wrapper.appendChild(editorContainer);
        const header = document.createElement('div');
        header.className = 'quill-header';
        header.innerHTML = `
            <span class="editor-title">Editor</span>
            <div class="toolbar-actions">
                <span class="source-btn btn btn-secondary btn-sm">Source</span>
                <span class="fullscreen-btn btn btn-secondary btn-sm">Fullscreen</span>
            </div>
        `;
        wrapper.insertBefore(header, editorContainer);
        const sourceContainer = document.createElement('div');
        sourceContainer.className = 'source-code-container';
        sourceContainer.setAttribute('contenteditable', 'true');
        sourceContainer.style.display = 'none';
        wrapper.appendChild(sourceContainer);
        const hiddenTextarea = editorContainer.closest('.mb-3').querySelector('textarea.hidden-textarea');
        if (!hiddenTextarea) {
            //console.error('Hidden textarea not found for Quill editor');
            return;
        }
        const resetStyles = document.createElement('style');
        resetStyles.textContent = `
            .ql-editor {
                padding: 0 !important;
                margin: 0 !important;
                line-height: 1.5 !important;
            }
            .ql-editor p {
                margin: 0 !important;
                padding: 0 !important;
            }
            .ql-editor.ql-blank::before {
                left: 0 !important;
            }
        `;
        document.head.appendChild(resetStyles);

        // Initialize Quill editor with proper configuration
        const quill = new Quill(editorContainer, {
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
            },
            placeholder: 'Write here...',
            bounds: editorContainer
        });
        if (hiddenTextarea.value) {
            quill.root.innerHTML = hiddenTextarea.value;
            quill.format('align', false); 
        }

        quill.on('text-change', function() {
            const cleanedHtml = cleanQuillHtml(quill.root.innerHTML);
            hiddenTextarea.value = cleanedHtml;
            const range = quill.getSelection();
            if (range) {
                quill.formatLine(range.index, 1, 'align', false);
            }
        });
        const form = editorContainer.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                const finalContent = cleanQuillHtml(quill.root.innerHTML);
                hiddenTextarea.value = finalContent;
            });
        }
        const sourceBtn = header.querySelector('.source-btn');
        sourceBtn.addEventListener('click', function() {
            const showSource = sourceContainer.style.display !== 'block';
            sourceContainer.style.display = showSource ? 'block' : 'none';
            editorContainer.style.display = showSource ? 'none' : 'block';
            sourceBtn.textContent = showSource ? 'Visual' : 'Source';
            
            if (showSource) {
                const htmlContent = cleanQuillHtml(quill.root.innerHTML);
                sourceContainer.textContent = htmlContent;
                sourceContainer.focus();
            } else {
                const cleanedHtml = cleanSourceHtml(sourceContainer.textContent);
                quill.root.innerHTML = cleanedHtml || '<p><br></p>';
                hiddenTextarea.value = cleanedHtml;
                quill.format('align', false);
            }
        });

        const fullscreenBtn = header.querySelector('.fullscreen-btn');
        fullscreenBtn.addEventListener('click', function() {
            wrapper.classList.toggle('fullscreen-mode');
            if (wrapper.classList.contains('fullscreen-mode')) {
                document.body.style.overflow = 'hidden';
                fullscreenBtn.textContent = 'Exit Fullscreen';
            } else {
                document.body.style.overflow = '';
                fullscreenBtn.textContent = 'Fullscreen';
            }
        });

        function cleanQuillHtml(html) {
            if (!html) return '';
            return html.replace(/ {4,}/g, ' ')
                      .replace(/<p>\s*<\/p>/g, '')
                      .replace(/(<p><\/p>)+/g, '')
                      .replace(/>\s+</g, '><')
                      .trim() || '';
        }

        function cleanSourceHtml(text) {
            return text.trim();
        }
        sourceContainer.addEventListener('blur', function() {
            const cleanedHtml = cleanSourceHtml(sourceContainer.textContent);
            hiddenTextarea.value = cleanedHtml;
            if (editorContainer.style.display !== 'none') {
                quill.root.innerHTML = cleanedHtml || '<p><br></p>';
                quill.format('align', false); 
            }
        });
        const style = document.createElement('style');
        style.textContent = `
            .source-code-container {
                font-family: monospace;
                white-space: pre-wrap;
                padding: 10px;
                background: #f8f8f8;
                border: 1px solid #ddd;
                min-height: 100px;
                color: #333;
                line-height: 1.5;
            }
            .source-code-container:empty::before {
                content: "No content";
                color: #999;
                font-style: italic;
            }
            .quill-editor-wrapper.fullscreen-mode {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 1000;
                background: white;
                margin: 0;
                padding: 20px;
            }
            .quill-editor-wrapper.fullscreen-mode .ql-container {
                height: calc(100vh - 100px) !important;
            }
            .ql-editor {
                text-align: left !important;
            }
        `;
        wrapper.appendChild(style);
    });
}
document.addEventListener('DOMContentLoaded', function() {
    initializeQuillEditorsTwo();
});



/**submut button fixed after scroll */

