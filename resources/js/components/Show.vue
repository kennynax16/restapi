<template>
    <div class="container mt-4 text-center">
        <div v-if="card" class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4 mb-3 text-center">
                    <h2 class="mb-3">{{ card.name }}</h2>
                    <img
                        v-if="card.urlPhoto"
                        :src="card.urlPhoto"
                        alt="Card Image"
                        class="img-fluid mb-3 mx-auto d-block"
                        style="max-width: 400px; object-fit: cover;"
                    />
                    <p class="mb-3">{{ card.description }}</p>
                    <p>Лайков: {{ card.likeCount }}</p>
                    <div class="mb-3">
                        <button
                            @click="toggleLike(card.id)"
                            class="btn btn-sm btn-outline-primary me-2 mb-2"
                        >
                            {{ card.isLiked ? 'Убрать лайк' : 'Поставить лайк' }}
                        </button>
                        <button
                            @click.prevent="deletePost(card.id)"
                            class="btn btn-sm btn-danger me-2 mb-2"
                        >
                            Удалить
                        </button>
                        <button
                            @click.prevent="toggleForm()"
                            class="btn btn-sm btn-secondary mb-2"
                        >
                            Изменить
                        </button>
                    </div>
                </div>
                <div v-if="showEditForm" class="card p-4 mb-3 text-center">
                    <h4 class="mb-3">Редактирование карточки</h4>
                    <form @submit.prevent="submitUpdate(card.id)">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Название</label>
                            <input
                                id="editName"
                                v-model="formData.editName"
                                type="text"
                                class="form-control text-center"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label for="editPhoto" class="form-label">Новое фото</label>
                            <input
                                id="editPhoto"
                                type="file"
                                class="form-control"
                                accept="image/*"
                                @change="handleFileChange"
                            />
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Описание</label>
                            <textarea
                                id="editDescription"
                                v-model="formData.editDescription"
                                class="form-control text-center"
                                rows="3"
                                required
                            ></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            Сохранить
                        </button>
                    </form>
                </div>
            </div>
            <!-- (Опционально) Комментарии -->
            <ComentsList v-if="card" :cardId="card.id" />
        </div>

        <div v-else>
            Загрузка...
        </div>
    </div>
</template>

<script setup>
import ComentsList from "@/components/ComentsList.vue";
import { useRoute, useRouter } from "vue-router";
import { onMounted, ref } from "vue";
import axios from "axios";

const route = useRoute();
const router = useRouter();
const cardId = ref(route.params.id) // Получаем id из маршрута

const card = ref(null);
const showEditForm = ref(false);


const formData = ref({
    editName: "",
    editDescription: ""
});


const photoFile = ref(null);


function handleFileChange(e) {
    if (e.target.files && e.target.files[0]) {
        photoFile.value = e.target.files[0];
    } else {
        photoFile.value = null;
    }
}


function toggleForm() {
    showEditForm.value = !showEditForm.value;
    if (showEditForm.value && card.value) {
        formData.value.editName = card.value.name;
        formData.value.editDescription = card.value.description;
        photoFile.value = null; // сброс выбранного файла
    }
}


async function fetchCard() {
    try {
        const cardId = route.params.id;
        const response = await axios.get(`/api/cards/${cardId}`);
        card.value = response.data.data;
        console.log("Загружена карточка:", response.data);
    } catch (error) {
        console.error("Ошибка при загрузке карточки", error);
    }
}


async function deletePost(cardId) {
    try {
        await axios.delete(`/api/cards/${cardId}`);
        console.log("Карточка удалена!");
        router.push({ name: "cards" });
    } catch (error) {
        console.error("Ошибка при удалении карточки", error);
    }
}


async function toggleLike(cardId) {
    try {
        const res = await axios.post(`/api/cards/${cardId}/like`);
        if (card.value) {
            card.value.isLiked = res.data.liked;
            card.value.likeCount += card.value.isLiked ? 1 : -1;
        }
    } catch (err) {
        console.error("Ошибка при лайке", err);
    }
}




async function submitUpdate(cardId) {
    try {
        const updateData = new FormData();
        updateData.append("name", formData.value.editName);
        updateData.append("description", formData.value.editDescription);
        if (photoFile.value) {
            updateData.append("photo", photoFile.value);
        }
        // Используем POST с _method=PUT для отправки multipart/form-data
        const response = await axios.post(`/api/cards/${cardId}?_method=PUT`, updateData, {
            headers: { "Content-Type": "multipart/form-data" }
        });
        console.log("Карточка обновлена:", response.data);
        await fetchCard()
        showEditForm.value = false;
    } catch (error) {
        console.error("Ошибка при обновлении карточки", error);
    }
}

onMounted(() => {
    fetchCard();
});
</script>

<style scoped>
.container {
    max-width: 800px;
}
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
button {
    transition: background-color 0.3s ease;
}
button:hover {
    opacity: 0.9;
}
</style>
