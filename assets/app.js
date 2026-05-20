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
import BookTable from './vue/components/bookTable.vue';
import AuthorTable from './vue/components/authorTable.vue';
import Paginator from './vue/components/paginator.vue';
import SelectAuthor from './vue/components/selectAuthor.vue';
import FormBook from './vue/components/formBook.vue';

const app = createApp({})

app.component('book-table', BookTable);
app.component('author-table', AuthorTable);
app.component('paginator', Paginator);
app.component('select-author', SelectAuthor);
app.component('form-book', FormBook);
app.mount("#app");
