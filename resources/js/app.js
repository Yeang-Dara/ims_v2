import './bootstrap';
import { createApp } from "vue";
import app from './app.vue';
import router from './router'

import 'vuetify/styles'
import { createVuetify} from 'vuetify';

import * as directives from 'vuetify/directives'
import { fa } from "vuetify/iconsets/fa";
import { aliases, mdi } from "vuetify/lib/iconsets/mdi";
import { VDataTable } from 'vuetify/labs/VDataTable'
import * as labs from 'vuetify/labs/components'
import "@mdi/font/css/materialdesignicons.css"; // Ensure you are using css-loader
import "@fortawesome/fontawesome-free/css/all.css";

import { setupComponents } from './config/setup-components';
const vuetify = createVuetify({
    components: {
        VDataTable,
        ...labs,
    },
    directives,
    // labs,
    template: '<App/>',
    icons: {
        defaultSet: "mdi",
        aliases,
        sets: {
          mdi,
          fa,
        },
    },
})

const App = createApp(app);
setupComponents(App);
// App.use(store);
App.use(router).use(vuetify).mount("#app");
