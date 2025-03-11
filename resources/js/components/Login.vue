<template>
    <div class="d-flex justify-content-center mt-5">
        <div class="card p-4" style="max-width: 400px; width: 100%;">
            <h2 class="mb-3 text-center">Вход</h2>
            <form @submit.prevent="login">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        v-model="email"
                        type="email"
                        class="form-control"
                        id="email"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input
                        v-model="password"
                        type="password"
                        class="form-control"
                        id="password"
                        required
                    />
                </div>
                <button type="submit" class="btn btn-primary w-100">Войти</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import {token ,setToken} from "@/auth";

const email = ref('')
const password = ref('')
const router = useRouter()

async function login() {
    try {

        const response = await axios.post('/api/login', {
            email: email.value,
            password: password.value
        })
        const newToken = response.data.token
        setToken(newToken)
        axios.defaults.headers.common['Authorization'] = `Bearer ${newToken}`
        router.push({ name: 'app' })
    } catch (err) {
        console.error('Ошибка при входе', err)
    }
}
</script>

<style scoped>

</style>
