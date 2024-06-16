import axios from "axios";

const axiosClient = axios.create({
  baseURL: `/`,
})

axiosClient.interceptors.request.use((config) => {
  const user = JSON.parse(localStorage.getItem('token-admin'));

  if (user && user.access_token){
    config.headers.Authorization = `Bearer ${user.access_token}`;
  }
  config.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
  return config;
})

axiosClient.interceptors.response.use((response) => {
  return response
}, (error) => {
  const {response} = error;
  if (response.status === 401) {
    localStorage.removeItem('token-admin')
    window.location = '/admin/login';
  } else if (response.status === 404) {
    //Show not found
  }
  throw error;
})

export default axiosClient
