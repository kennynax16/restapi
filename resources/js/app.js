import { createApp } from 'vue'
import App from './components/App.vue'
import router from './router'
import axios from 'axios'
import { setToken, token } from '@/auth'

import 'bootstrap/dist/css/bootstrap.min.css'


const savedToken = localStorage.getItem('token')
if (savedToken) {
    setToken(savedToken)
}


if (token.value) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
}


const app = createApp(App)
app.use(router)
app.mount('#app')
