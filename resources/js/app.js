import './bootstrap';
import 'alpinejs';
import 'flowbite';
import './editor.js';
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { createApp } from 'vue' 
import ContentEditor from './components/ContentEditor.vue' 

window.flatpickr = flatpickr;

if (document.getElementById('content-editor-app')) {
    createApp(ContentEditor).mount('#content-editor-app')
}


