document.querySelectorAll('.snow-editor').forEach(function(editor) {
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
    quill.on('text-change', function() {
        hiddenTextarea.value = quill.root.innerHTML;
    });
});
var quill = new Quill('#bubble-editor', {
    theme: 'bubble'
});


