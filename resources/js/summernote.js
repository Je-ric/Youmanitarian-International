
$(document).ready(function () {
    // Enhanced Summernote Configuration
    $('#editor').summernote({
        minHeight: 200, // Set your minimum height here (e.g., 200px)
        height: 400,
        placeholder: 'Start writing your amazing content here...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph', 'height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview']],
            ['misc', ['undo', 'redo']],
            ['custom', ['wordcount', 'readingtime']]
        ],
        buttons: {
            wordcount: function (context) {
                var ui = $.summernote.ui;
                return ui.button({
                    contents: '<i class="bx bx-text"></i>',
                    tooltip: 'Word Count',
                    click: function () {
                        updateContentStats();
                    }
                }).render();
            },
            readingtime: function (context) {
                var ui = $.summernote.ui;
                return ui.button({
                    contents: '<i class="bx bx-time"></i>',
                    tooltip: 'Reading Time',
                    click: function () {
                        updateContentStats();
                    }
                }).render();
            }
        },
        styleTags: [
            'p',
            { title: 'Blockquote', tag: 'blockquote', className: 'blockquote border-l-4 border-gray-300 pl-4 italic', value: 'blockquote' },
            'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
        ],
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'],
        fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '36', '48'],
        inheritPlaceholder: true,
        dialogsInBody: true,
        dialogsFade: true,
        disableDragAndDrop: false,
        shortcuts: true,
        tabDisable: false,
        codeviewFilter: true,
        codeviewIframeFilter: true,
        spellCheck: true,
        disableGrammar: false,
        callbacks: {
            onChange: function (contents, $editable) {
                $('#editor').val(contents);
                updateContentStats();
                autoResizeEditor();
            },
            onInit: function () {
                console.log('Enhanced Summernote Editor Initialized');
                updateContentStats();
                autoResizeEditor();
            }
            // ,
            // onImageUpload: function(files) {
            //     // Handle image upload
            //     for (let i = 0; i < files.length; i++) {
            //         uploadImage(files[i]);
            //     }
            // }
        }
    });

    // Auto-generate slug from title
    $('#title').on('input', function () {
        var title = $(this).val();
        var slug = title.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-+|-+$/g, '');
        $('#slug').val(slug);
    });

    // Auto-save functionality
    let autoSaveTimer;
    $('#editor, #title, #slug').on('input', function () {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(function () {
            // Auto-save logic here
            console.log('Auto-saving...');
        }, 30000); // Auto-save every 30 seconds
    });
});

// Content Statistics
function updateContentStats() {
    const content = $('#editor').summernote('code');
    const textContent = $(content).text();
    const wordCount = textContent.trim().split(/\s+/).length;
    const charCount = textContent.length;
    const readingTime = Math.ceil(wordCount / 200); // Average reading speed

    $('#wordCount').text(wordCount);
    $('#charCount').text(charCount);
    $('#readingTime').text(readingTime + ' min');
}

// function toggleFullscreen() {
//     $('#editor').summernote('fullscreen.toggle');
//     toggleOffcanvas();
// }

// Gallery image deletion
function deleteGalleryImage(imageId) {
    if (confirm('Are you sure you want to delete this image?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/content/images/${imageId}`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);

        document.body.appendChild(form);
        form.submit();
    }
}

// Image upload handler
function uploadImage(file) {
    const formData = new FormData();
    formData.append('image', file);
    formData.append('_token', '{{ csrf_token() }}');

    // You can implement AJAX upload here
    console.log('Uploading image:', file.name);
}

// Keyboard shortcuts
document.addEventListener('keydown', function (e) {
    if (e.ctrlKey || e.metaKey) {
        switch (e.key) {
            case 's':
                e.preventDefault();
                saveDraft();
                break;
            case 'p':
                e.preventDefault();
                previewContent();
                break;
        }
    }
});

function autoResizeEditor() {
    var $editable = $('.note-editable');
    $editable.css('height', 'auto'); // Reset height
    var scrollHeight = $editable[0].scrollHeight;
    var minHeight = 200; // Match your minHeight
    $editable.css('height', Math.max(scrollHeight, minHeight) + 'px');
}

// Call on change and init
$('#editor').on('summernote.change summernote.init', function () {
    autoResizeEditor();
});


// ---------------------------------------------
// Extra
// ---------------------------------------------

$(document).on('keydown', '.note-editable', function(e) {
    if (e.key === 'Tab') {
        e.preventDefault();
        document.execCommand('insertText', false, '    '); // 4 spaces
    }
});

$(document).on('keydown', '.note-editable', function(e) {
    const pairs = {
        '(': ')',
        '{': '}',
        '[': ']',
        '"': '"',
        "'": "'",
        '`': '`'
    };

    // Auto-pair
    if (pairs[e.key]) {
        e.preventDefault();

        const openChar = e.key;
        const closeChar = pairs[e.key];

        // Insert both chars
        document.execCommand('insertText', false, openChar + closeChar);

        // Move caret back one step (inside the pair)
        const sel = window.getSelection();
        if (sel.rangeCount > 0) {
            const range = sel.getRangeAt(0);
            range.setStart(range.startContainer, range.startOffset - 1);
            range.collapse(true);
            sel.removeAllRanges();
            sel.addRange(range);
        }
    }

    // Smart closing: skip over if next char matches
    if (Object.values(pairs).includes(e.key)) {
        const sel = window.getSelection();
        if (sel.rangeCount > 0) {
            const range = sel.getRangeAt(0);
            const container = range.startContainer;
            const text = container.textContent || '';
            const pos = range.startOffset;

            if (text[pos] === e.key) {
                e.preventDefault();
                // Move caret forward
                range.setStart(container, pos + 1);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    }
});
