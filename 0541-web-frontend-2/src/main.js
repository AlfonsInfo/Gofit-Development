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
import * as ConfirmDialog from 'vuejs-confirm-dialog'
const app = createApp(App)
app.use(VTooltip)
app.use(router)
app.use(ConfirmDialog)
// app.use(ToastPlugin)

app.mount('#app')

const $toast = useToast();
$toast.success('Welcome To Aplikasi Gofit!');