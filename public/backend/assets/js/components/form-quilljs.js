$(document).ready(function () {
    function initializeQuillEditors() {
        document.querySelectorAll('.snow-editor').forEach(function(editorContainer) {
            if (!editorContainer.classList.contains('ql-container')) {
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
                var quill = new Quill(editorContainer, {
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
                var hiddenTextarea = editorContainer.nextElementSibling;
                quill.on('text-change', function() {
                    hiddenTextarea.value = cleanQuillHtml(quill.root.innerHTML);
                });
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
                    if (html === '<p><br></p>' || html === '<div><br></div>') {
                        return '';
                    }
                    return html;
                }
    
                function cleanSourceHtml(text) {
                    return text.trim();
                }
                sourceContainer.addEventListener('blur', function() {
                    const cleanedHtml = cleanSourceHtml(sourceContainer.textContent);
                    hiddenTextarea.value = cleanedHtml;
                    if (editorContainer.style.display !== 'none') {
                        quill.root.innerHTML = cleanedHtml || '<p><br></p>';
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
                    .html-tag {
                        color: #5d7186;
                        font-weight: bold;
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
                    }
                    .quill-editor-wrapper.fullscreen-mode .ql-container {
                        height: calc(100vh - 45px) !important;
                    }
                `;
                wrapper.appendChild(style);
            }
        });
    }
    
    initializeQuillEditors();
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

