// import './bootstrap';
import { createApp } from 'vue';
import Alpine from 'alpinejs';
import UserList from './components/UserList.vue'; // تأكد من مسار المكون

// إنشاء التطبيق Vue
const app = createApp({});

// تسجيل المكون
app.component('user-list', UserList);

// تثبيت Alpine.js
window.Alpine = Alpine;
Alpine.start();

// ربط التطبيق بـ #app
app.mount('#app');
