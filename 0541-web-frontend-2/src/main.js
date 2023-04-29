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
import * as ConfirmDialog from 'vuejs-confirm-dialog';
import "https://code.jquery.com/jquery-3.5.1.js";
import "https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js";
import "https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"
import { jsPDF } from "jspdf"
import axios from 'axios'


console.log(router)
const app = createApp(App)
app.use(VTooltip)
app.use(router)
app.use(jsPDF)
app.use(ConfirmDialog)
// app.use(BootstrapVue)
app.config.globalProperties.$http = axios.create({baseURL : 'http://127.0.0.1:8000/api'})
app.provide('$http',app.config.globalProperties.$http) 
app.mount('#app')

const $toast = useToast();
$toast.success('Welcome To Aplikasi Gofit!');


