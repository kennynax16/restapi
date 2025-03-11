import { ref } from "vue"
import axios from "axios"

export const token = ref(localStorage.getItem('token') || '')

export function setToken(newToken) {
    if (!newToken) {
        console.error("Попытка установить пустой токен!")
        return
    }

    token.value = newToken
    localStorage.setItem('token', newToken)
    axios.defaults.headers.common['Authorization'] = `Bearer ${newToken}`
    console.log("✅ Токен установлен:", newToken)
}

export function removeToken() {
    token.value = ''
    localStorage.removeItem('token')
    delete axios.defaults.headers.common['Authorization']
    console.log("❌ Токен удалён")
}
