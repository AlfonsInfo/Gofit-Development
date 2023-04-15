import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import 'bootstrap/dist/css/bootstrap.css'
import 'jquery/dist/jquery'
import 'popper.js/dist/popper'
import 'bootstrap/dist/js/bootstrap'
import './assets/main.css'
import "mdi-icons/css/materialdesignicons.min.css";

const app = createApp(App)

app.use(router)

app.mount('#app')
