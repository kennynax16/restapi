<template>
    <div id="app">
        <!-- Навигационная панель (navbar) -->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-3">
            <div class="container">
                <!-- Логотип / Название -->
                <router-link class="navbar-brand" to="/">My SPA</router-link>

                <!-- Кнопка «гамбургер» для мобильных -->
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Содержимое меню -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/">Главная</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/cards">Карточки</router-link>
                        </li>


                        <li v-if="!isLoggedIn" class="nav-item">
                            <router-link class="nav-link" to="/login">Вход</router-link>
                        </li>
                        <li v-if="!isLoggedIn" class="nav-item">
                            <router-link class="nav-link" to="/register">Регистрация</router-link>
                        </li>

                        <li v-else class="nav-item">
                            <a href="#" class="nav-link" @click.prevent="logout">Выход</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

        <!-- Основной контейнер с контентом -->
        <main class="container mb-5">
            <router-view />
        </main>

        <!-- Подвал сайта -->
        <footer class="bg-light text-center text-lg-start">
            <div class="text-center p-3">
                © 2025 My SPA Application
            </div>
        </footer>
    </div>
</template>

<script>
import {computed,ref} from "vue";
import router from "@/router";
import {token ,removeToken} from "@/auth";

export default {
    name: 'App',

    setup(){

        const isLoggedIn = computed(() => !!token.value)

        function logout()
        {
            removeToken()
            router.push({name :'login'})
        }



        return { isLoggedIn,logout}
    }


}
</script>

<style scoped>

</style>
