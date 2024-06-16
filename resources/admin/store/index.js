import { createStore } from "vuex";
import { auth } from "./auth.module";
import {menu} from "./menu.module";
import {settings} from "./settings.module";
import {user} from "./user.module";
import {theme} from "./theme.module";

const store = createStore({
    modules: {
        auth,
        menu,
        user,
        settings,
        theme
    },
});

export default store;
