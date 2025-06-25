<template>
  <div>
    <editor-content :editor="editor" class="tiptap" />
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'

const editor = ref(null)

onMounted(() => {
  editor.value = new Editor({
    extensions: [StarterKit],
    content: document.getElementById('content-editor-app').dataset.body || '',
    onUpdate: ({ editor }) => {
      document.getElementById('body').value = editor.getHTML()
    },
  })
  // Set initial value for hidden input
  document.getElementById('body').value = editor.value.getHTML()
})

onBeforeUnmount(() => {
  if (editor.value) {
    editor.value.destroy()
  }
})
</script>

<style>
.tiptap {
  min-height: 200px;
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  padding: 1rem;
  background: #f9fafb;
}
</style> 