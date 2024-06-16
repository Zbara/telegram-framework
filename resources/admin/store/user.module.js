import axiosClient from "@/core/axios-client.js";

export const user = {
    namespaced: true,
    state: {
        id: '',
        name: '',
        email: '',
        password: '',
        username: '',
        role_id: '',
    },
    mutations: {
        setUser(state, userData) {
            for (let i in userData) {
                state[i] = userData[i];
            }
        }
    },
    actions: {
        async initUser({ commit }) {

            try {
                const { data } = await axiosClient.get('/admin/auth/getUser');
                commit('setUser', data.response);
            } catch (error) {
                console.error('Error fetching user data:', error);
            }
        },
    },
};
