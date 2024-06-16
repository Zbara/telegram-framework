export const theme = {
    namespaced: true,
    state: {
    },
    mutations: {
        initThemeState(state) {
            const storedTheme = localStorage.getItem("admin-theme")
            const selectedTheme = storedTheme ? storedTheme : "light"

            if (selectedTheme === 'dark') {
                document.body.setAttribute("data-bs-theme", selectedTheme)
            } else {
                document.body.removeAttribute("data-bs-theme")
            }
        },
    },
    actions: {
        initTheme({commit}) {
            commit('initThemeState');
        },
    },
};
