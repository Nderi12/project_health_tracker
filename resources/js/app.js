import './bootstrap';

import axios from 'axios'
// window.axios = require("axios");
// import { createApp } from "vue";
import { createApp } from "vue/dist/vue.esm-bundler";

import router from './router'
import store from "./store"

import { createPinia } from "pinia";
import { Tooltip } from "bootstrap";

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const app = createApp({});

app.use(createPinia());
app.use(store);
app.use(router);
app.use(VueSweetalert2)

app.directive("tooltip", (el) => {
  new Tooltip(el);
});

app.mount("#app");
