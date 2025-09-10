import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'

import '../css/editor.css';

document.addEventListener('DOMContentLoaded', () => {
    const editorElement = document.querySelector('#editor');
    const hiddenInput = document.querySelector('#body');
    if (!editorElement || !hiddenInput) return;

    const editor = new Editor({
        element: editorElement,
        extensions: [StarterKit],
        content: hiddenInput.value || '',
        onUpdate: ({ editor }) => {
            hiddenInput.value = editor.getHTML();
        },
    });

    // Set initial content if editing
    if (hiddenInput.value) {
        editor.commands.setContent(hiddenInput.value);
    }
});
