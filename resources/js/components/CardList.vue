<template>
    <div class="container my-4">
        <h2 class="text-center mb-4">Список карточек</h2>

        <!-- Если нет карточек, показываем alert -->
        <div v-if="cards.length === 0" class="alert alert-warning text-center">
            Нет карточек.
        </div>

        <!-- Если карточки есть, показываем сетку -->
        <div v-else class="row row-cols-1 row-cols-md-3 g-4">
            <div v-for="card in cards" :key="card.id" class="col">
                <div class="card h-100 shadow-sm">
                    <!-- Изображение карточки -->
                    <img
                        :src="card.urlPhoto"
                        alt="Photo"
                        class="card-img-top"
                        style="height: 200px; object-fit: cover;"
                    />
                    <div class="card-body">
                        <h5 class="card-title">{{ card.name }}</h5>
                        <p class="card-text">{{ card.description }}</p>
                    </div>
                    <!-- Ссылка на show-страницу -->
                    <router-link :to="{ name: 'show', params: { id: card.id } }">
                        Подробнее
                    </router-link>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <small class="text-muted">Лайков: {{ card.likeCount }}</small>
                        <button
                            class="btn btn-sm"
                            :class="card.isLiked ? 'btn-danger' : 'btn-outline-danger'"
                            @click="toggleLike(card)"
                        >
                            {{ card.isLiked ? 'Убрать лайк' : 'Поставить лайк' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Кнопки пагинации -->
        <div class="d-flex justify-content-between mt-4">
            <button
                v-if="meta.current_page > 1"
                class="btn btn-primary"
                @click="fetchCards(meta.current_page - 1)"
            >
                Назад
            </button>
            <button
                v-if="meta.current_page < meta.last_page"
                class="btn btn-primary ms-auto"
                @click="fetchCards(meta.current_page + 1)"
            >
                Вперёд
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const cards = ref([])
const meta = ref({})


async function fetchCards(page = 1) {
    try {
        console.log("Отправляемый токен:", axios.defaults.headers.common['Authorization']);

        const res = await axios.get(`/api/cards?page=${page}`)

        cards.value = res.data.data
        meta.value = res.data.meta

        console.log("Ответ API (meta):", res.data.meta);


    } catch (err) {
        console.error(err)
    }
}

function toggleLike(card) {
    axios.post(`/api/cards/${card.id}/like`)
        .then(res => {
            card.isLiked = res.data.liked;
            card.likeCount += card.isLiked ? 1 : -1; // Обновляем лайки локально
        })
        .catch(err => console.error(err));
}



onMounted(() => {
    fetchCards()
})
</script>

<style scoped>
.card-img-top {
    transition: transform 0.3s;
}
.card-img-top:hover {
    transform: scale(1.05);
}
</style>
