/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
globalThis.__VUE_OPTIONS_API__ = true;
globalThis.__VUE_PROD_DEVTOOLS__ = false;
globalThis.__VUE_PROD_HYDRATION_MISMATCH_DETAILS__ = true;

import './styles/app.css';

import { createApp } from 'vue';
import Pagination from './vue/components/pagination.vue';

const app = createApp({})

app.component('pagination', Pagination);
app.mount("#app");
