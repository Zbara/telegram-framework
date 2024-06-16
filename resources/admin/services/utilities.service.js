import axiosClient from "@/core/axios-client.js";

class UtilitiesService {

    getSystem() {
        return axiosClient
            .get('/admin/services/getConfig');
    }

    getMain() {
        return axiosClient
            .get('/admin/services/getMain');
    }
    getServer() {
        return axiosClient
            .get('/admin/services/getServer');
    }
}

export default new UtilitiesService();
