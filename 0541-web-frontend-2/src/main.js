import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import 'bootstrap/dist/css/bootstrap.css'
import 'jquery/dist/jquery'
import 'popper.js/dist/popper'
import 'bootstrap/dist/js/bootstrap'
import './assets/main.css'
import "mdi-icons/css/materialdesignicons.min.css";
import 'vue-toast-notification';
import VTooltip from 'v-tooltip';
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
const app = createApp(App)
app.use(VTooltip)
app.use(router)
// app.use(ToastPlugin)

app.mount('#app')

const $toast = useToast();
$toast.success('Welcome To Aplikasi Gofit!');