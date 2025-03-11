<template>
    <div class="d-flex justify-content-center mt-5">
        <div class="card p-4" style="max-width: 400px; width: 100%;">
            <h2 class="mb-3 text-center">Регистрация</h2>
            <form @submit.prevent="register">
                <div class="mb-3">
                    <label for="name" class="form-label">Имя</label>
                    <input
                        v-model="name"
                        type="text"
                        class="form-control"
                        id="name"
                        required
                    />
                </div>
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
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                    <input
                        v-model="password_confirmation"
                        type="password"
                        class="form-control"
                        id="password_confirmation"
                        required
                    />
                </div>
                <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const router = useRouter()

async function register() {
    try {
        await axios.post('/api/register', {
            name: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: password_confirmation.value
        })
        router.push({ name: 'login' })
    } catch (err) {
        console.error('Ошибка при регистрации', err)
    }
}
</script>

<style scoped>

</style>
