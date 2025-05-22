<template>
  <aside class="hidden lg:flex lg:flex-shrink-0">
    <div class="flex flex-col w-64">
      <div class="flex flex-col h-0 flex-1 bg-white border-r border-gray-200">
        <nav class="mt-5 flex-1 px-2 space-y-1">
          <router-link
            to="/"
            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md"
            :class="[
              $route.name === 'dashboard' 
                ? 'bg-indigo-50 text-indigo-700' 
                : 'text-gray-700 hover:text-indigo-700 hover:bg-gray-50'
            ]"
          >
            <svg 
              class="mr-3 h-6 w-6" 
              :class="[
                $route.name === 'dashboard' 
                  ? 'text-indigo-500' 
                  : 'text-gray-400 group-hover:text-indigo-500'
              ]"
              fill="none" 
              stroke="currentColor" 
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"/>
            </svg>
            Dashboard
          </router-link>

          <router-link
            to="/emails"
            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md"
            :class="[
              $route.name === 'emails' 
                ? 'bg-indigo-50 text-indigo-700' 
                : 'text-gray-700 hover:text-indigo-700 hover:bg-gray-50'
            ]"
          >
            <svg 
              class="mr-3 h-6 w-6" 
              :class="[
                $route.name === 'emails' 
                  ? 'text-indigo-500' 
                  : 'text-gray-400 group-hover:text-indigo-500'
              ]"
              fill="none" 
              stroke="currentColor" 
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Controle de Emails
          </router-link>
        </nav>
      </div>
    </div>
  </aside>

  <div 
    v-if="open"
    class="lg:hidden fixed inset-0 flex z-50"
  >
    <div 
      class="fixed inset-0 bg-gray-600 bg-opacity-75"
      @click="$emit('close')"
    ></div>

    <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
      <div class="absolute top-0 right-0 -mr-12 pt-2">
        <button
          @click="$emit('close')"
          class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
        >
          <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
        <div class="flex-shrink-0 flex items-center px-4">
          <h2 class="text-lg font-semibold text-gray-900">Menu</h2>
        </div>
        <nav class="mt-5 px-2 space-y-1">
          <router-link
            to="/"
            @click="$emit('close')"
            class="group flex items-center px-2 py-2 text-base font-medium rounded-md"
            :class="[
              $route.name === 'dashboard' 
                ? 'bg-indigo-50 text-indigo-700' 
                : 'text-gray-700 hover:text-indigo-700 hover:bg-gray-50'
            ]"
          >
            <svg class="mr-4 h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
            </svg>
            Dashboard
          </router-link>

          <router-link
            to="/emails"
            @click="$emit('close')"
            class="group flex items-center px-2 py-2 text-base font-medium rounded-md"
            :class="[
              $route.name === 'emails' 
                ? 'bg-indigo-50 text-indigo-700' 
                : 'text-gray-700 hover:text-indigo-700 hover:bg-gray-50'
            ]"
          >
            <svg class="mr-4 h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Controle de Emails
          </router-link>
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  open: Boolean
})

defineEmits(['close'])
</script>