import { createApp } from 'vue'
import store from './store'
import router from './router/routes'
import './index.css'
import App from './App.vue'
import axios from 'axios'

// const token = store.state.token
// axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

createApp(App).use(store).use(router).mount('#app')
