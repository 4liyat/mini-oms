import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';

// Crea una instancia de la aplicación Vue
const app = createApp(App);

// Usa Pinia para la gestión de estado
app.use(createPinia());

// Usa Vue Router para la navegación
app.use(router);

// Monta la aplicación en el DOM
app.mount('#app');
