<template>
  <div id="app">
    <LoginPage v-if="!authStore.isAuthenticated" />
    
    <MainLayout v-else />
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useAuthStore } from './stores/auth'
import LoginPage from './components/auth/LoginPage.vue'
import MainLayout from './components/layout/MainLayout.vue'

const authStore = useAuthStore()

onMounted(() => {
  authStore.initialize()
})
</script>