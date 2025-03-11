import { createRouter, createWebHistory } from 'vue-router'
import Home from './components/Home.vue'
import Login from './components/Login.vue'
import Register from './components/Register.vue'
import CardsList from './components/CardList.vue'
import Show from "./components/Show.vue";


const routes = [
    { path: '/', component: Home, name: 'app' },
    { path: '/cards/:id', component: Show, name: 'show' },
    { path: '/login', component: Login, name: 'login' },
    { path: '/register', component: Register, name: 'register' },
    { path: '/cards', component: CardsList, name: 'cards' }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
