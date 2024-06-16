import axiosClient from "@/core/axios-client.js";
class AuthService {
    login(user) {
        return axiosClient
            .post('/admin/auth/login', {
                email: user.email,
                password: user.password
            })
            .then(response => {
                if (response.data.access_token) {
                    localStorage.setItem('token-admin', JSON.stringify(response.data));
                }
                return response.data;
            }).catch((e) => {
                return Promise.reject(e.response.data);
            });
    }

    getSession(api = 'api') {
        return axiosClient
            .get(`/${api}/auth/getSession`)
            .then(response => {
                return response.data;
            });
    }
    logout() {
        localStorage.removeItem('token-admin');
        localStorage.removeItem('menu');
    }
}
export default new AuthService();
