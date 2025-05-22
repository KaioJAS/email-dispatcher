<template>
  <header class="bg-white shadow-sm border-b border-gray-200">
    <div class="px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        
        <div class="flex items-center">
          <button
            @click="$emit('toggle-sidebar')"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 lg:hidden"
          >
            <span class="sr-only">Abrir menu</span>
            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>

          <router-link to="/" class="flex items-center ml-4 lg:ml-0">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <h1 class="ml-2 text-xl font-semibold text-gray-900">
              Email Dispatcher
            </h1>
          </router-link>
        </div>

        <div class="hidden md:block">
          <span class="text-sm font-medium text-gray-700">
            {{ $route.meta?.title || 'Dashboard' }}
          </span>
        </div>

        <div class="flex items-center">
          <div class="hidden sm:block mr-4">
            <span class="text-sm text-gray-700">
              Olá, <span class="font-medium">{{ authStore.userName }}</span>
            </span>
          </div>
          
          <div class="relative">
            <button
              @click="showUserMenu = !showUserMenu"
              class="flex items-center p-2 text-sm rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                <span class="text-sm font-medium text-indigo-700">{{ userInitials }}</span>
              </div>
              <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>

            <div
              v-show="showUserMenu"
              class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
            >
              <div class="py-1">
                <div class="px-4 py-2 text-sm text-gray-700 border-b">
                  {{ authStore.userEmail }}
                </div>
                <button
                  @click="handleLogout"
                  class="group flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  <svg class="mr-3 h-4 w-4 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                  </svg>
                  Sair
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      v-if="showUserMenu"
      @click="showUserMenu = false"
      class="fixed inset-0 z-40"
    ></div>
  </header>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useAuthStore } from '../../stores/auth'

const authStore = useAuthStore()
const showUserMenu = ref(false)

const userInitials = computed(() => {
  const name = authStore.userName
  return name ? name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() : 'U'
})

const handleLogout = async () => {
  showUserMenu.value = false
  await authStore.logout()
}

defineEmits(['toggle-sidebar'])
</script>