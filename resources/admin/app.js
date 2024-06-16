import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import * as bootstrap from 'bootstrap';
import store from "./store";
import '@/core/libs/tooltip'

import globalMixins from '@/core/globalMixins.js';

createApp(App)
    .use(router)
    .mixin(globalMixins)
    .use(store)
    .mount("#app");
