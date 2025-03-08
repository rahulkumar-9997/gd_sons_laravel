$(document).ready(function () {
    function initializeQuillEditors() {
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
    initializeQuillEditors();

    // Bubble theme initialization (for static editor)
    if (document.querySelector('#bubble-editor')) {
        var bubbleQuill = new Quill('#bubble-editor', {
            theme: 'bubble'
        });
    }

});
/*document.querySelectorAll('.snow-editor').forEach(function(editor) {
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
});



// Bubble theme
var quill = new Quill('#bubble-editor', {
    theme: 'bubble'
});
*/

