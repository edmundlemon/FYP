import axios from 'axios';
import router from '../router/routes'; // Adjust the path based on your project structure
import store from '../store'; // Adjust the path based on your project structure

const axiosInstance = axios.create({
  baseURL: 'http://localhost:8000/api', // Replace with your API base URL
  headers: {
    'Content-Type': 'application/json',
  },
  method: 'GET',
});

axiosInstance.interceptors.request.use(
  config => {
    const token = store.state.token;
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  },
  error => Promise.reject(error)
);

axiosInstance.interceptors.response.use(
  response => response,
  error => {
    if (error.response) {
      const { status } = error.response;
      if (status === 401) {
        store.commit('logout');
        router.push('/login');
      } else if (status === 403) {
        router.push('/dashboard');
      }
    }
    return Promise.reject(error);
  }
);

// axiosInstance.defaults.headers.common['Authorization'] = `Bearer ${store.state.token}`;


export default axiosInstance;