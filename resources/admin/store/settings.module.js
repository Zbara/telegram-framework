import UtilitiesService from "@/services/utilities.service";

export const settings = {
    namespaced: true,
    state: {
        app_type: null,
        config: [],
        language: [],
    },
    mutations: {
        initializeState(state) {
            state.app_type = import.meta.env.VITE_BOT_TYPE;

            UtilitiesService.getSystem().then((resp) => {
                state.config = resp.data.config;
                state.language = resp.data.language;
            });
        },
        unreadQuestions(state, data) {
            state.unreadQuestions = data;
        }
    },
    actions: {
        initApp({commit}) {
            commit('initializeState');
        },
    },
};
