<template>
    <div class="comments">
        <h4>Комментарии</h4>

        <!-- Список комментариев -->
        <div v-if="comments.length > 0">
            <div
                v-for="comment in comments"
                :key="comment.id"
                class="border rounded p-2 mb-2"
            >
                <p class="mb-1">{{ comment.text }}</p>
                <small class="text-muted">
                    Автор: {{ comment.user?.name || 'Неизвестен' }}
                    • {{ comment.created_at }}
                </small>
            </div>
        </div>
        <div v-else>
            <p>Нет комментариев</p>
        </div>

        <!-- Форма добавления комментария -->
        <div class="mt-3">
            <h5>Оставить комментарий</h5>
            <form @submit.prevent="addComment">
                <div class="mb-2">
          <textarea
              v-model="newComment"
              class="form-control"
              rows="2"
              placeholder="Напишите комментарий..."
              required
          ></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Отправить</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

// Принимаем cardId как пропс
const props = defineProps({
    cardId: {
        type: Number,
        required: true
    }
})

const comments = ref([])       // Массив комментариев
const newComment = ref('')     // Текст нового комментария

// Загружаем комментарии при монтировании
async function fetchComments() {
    try {
        const res = await axios.get(`/api/cards/${props.cardId}/comments`)
        comments.value = res.data.data // это массив
        console.log(comments.value)

    } catch (error) {
        console.error('Ошибка при получении комментариев:', error)
    }
}

async function addComment() {
    if (!newComment.value.trim()) return

    try {
        const res = await axios.post(`/api/cards/${props.cardId}/comments`, {
            text: newComment.value


        })

        console.log("Ответ сервера при добавлении комментария:", res.data);
        // Сервер вернёт { message: 'Comment added', comment: { ... } }
        // Добавляем этот комментарий в начало списка (или в конец)
        comments.value.unshift(res.data.data)
        newComment.value = ''
    } catch (error) {
        console.error('Ошибка при добавлении комментария:', error)
    }
}

onMounted(() => {
    fetchComments()
})
</script>

<style scoped>
.comments {
    margin-top: 20px;
}
</style>
