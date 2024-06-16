export const menu = {
    namespaced: true,
    state: {
        menus: {
            settings: false,
            generate: false,
            bots: false,
            users: false,
            notification: false,
            payment: false,
            channels: false
        },
    },
    mutations: {
        toggleMenu(state, menuId) {
            state.menus[menuId] = !state.menus[menuId];

            localStorage.setItem(`menu`, JSON.stringify(state.menus));
        },
        initializeMenuState(state) {
            const menuState = JSON.parse(localStorage.getItem('menu'));

            if (menuState) {
                state.menus = menuState;
            }
        },
    },
    actions: {
        initApp({commit}) {
            commit('initializeMenuState');
        },
    },
};
