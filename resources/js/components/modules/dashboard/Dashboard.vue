<template>
  <div>
    <div class="flex justify-between items-center mb-8">
      <div class="flex items-center space-x-3">
        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center shadow-sm">
          <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
          </svg>
        </div>
        <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
      </div>
      
    </div>

    <div v-if="loading" class="flex justify-center items-center h-64">
      <div class="text-gray-500">Carregando estatísticas...</div>
    </div>

    <div v-else>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-600">Emails Enviados</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.sent }}</p>
            </div>
          </div>
          <div class="mt-4 flex justify-between items-center">
            <span class="text-xs text-gray-500">{{ stats.sentPercent }}% do total</span>
            <div class="w-24 bg-gray-200 rounded-full h-2">
              <div class="bg-green-500 h-2 rounded-full" :style="{ width: stats.sentPercent + '%' }"></div>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-600">Aguardando Envio</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.pending }}</p>
            </div>
          </div>
          <div class="mt-4 flex justify-between items-center">
            <span class="text-xs text-gray-500">{{ stats.pendingPercent }}% do total</span>
            <div class="w-24 bg-gray-200 rounded-full h-2">
              <div class="bg-yellow-500 h-2 rounded-full" :style="{ width: stats.pendingPercent + '%' }"></div>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-600">Falhas</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.error }}</p>
            </div>
          </div>
          <div class="mt-4 flex justify-between items-center">
            <span class="text-xs text-gray-500">{{ stats.errorPercent }}% do total</span>
            <div class="w-24 bg-gray-200 rounded-full h-2">
              <div class="bg-red-500 h-2 rounded-full" :style="{ width: stats.errorPercent + '%' }"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 md:col-span-2">
          <h2 class="text-lg font-semibold text-gray-900 mb-4">Status de Envios</h2>
          <div class="relative pt-1">
            <div class="flex mb-2 items-center justify-between">
              <div>
                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 bg-green-200">
                  Taxa de Sucesso
                </span>
              </div>
              <div class="text-right">
                <span class="text-xs font-semibold inline-block text-green-600">
                  {{ stats.successRate }}%
                </span>
              </div>
            </div>
            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
              <div :style="{ width: stats.successRate + '%' }" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"></div>
            </div>
          </div>

          <div class="mt-6">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Disparos por Dia</h3>
            <div class="flex items-end space-x-2 h-32 mt-2">
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
          <h2 class="text-lg font-semibold text-gray-900 mb-4">Resumo de Atividades</h2>
          
          <div class="space-y-4">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">Hoje</p>
                <p class="text-xs text-gray-500">{{ stats.todayEmails }} emails enviados</p>
              </div>
            </div>
            
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">Tempo médio</p>
                <p class="text-xs text-gray-500">{{ stats.avgProcessTime }} seg. de processamento</p>
              </div>
            </div>
            
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">Usuários</p>
                <p class="text-xs text-gray-500">{{ stats.activeUsers }} usuários ativos</p>
              </div>
            </div>
          </div>

          <div class="mt-6 pt-4 border-t border-gray-100">
            <router-link to="/emails" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
              Ver todos os disparos
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
              </svg>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useEmailsStore } from '../../../stores/emails'

const emailsStore = useEmailsStore()
const loading = ref(true)

const stats = ref({
  sent: 0,
  pending: 0,
  error: 0,
  total: 0,
  sentPercent: 0,
  pendingPercent: 0,
  errorPercent: 0,
  successRate: 0,
  todayEmails: 0,
  avgProcessTime: 0,
  activeUsers: 0
})

const calculateStats = () => {
  const sent = emailsStore.emails.filter(email => email.status === 'enviado').length
  const pending = emailsStore.emails.filter(email => email.status === 'pendente').length
  const error = emailsStore.emails.filter(email => email.status === 'erro').length
  const total = sent + pending + error

  const sentPercent = total > 0 ? Math.round((sent / total) * 100) : 0
  const pendingPercent = total > 0 ? Math.round((pending / total) * 100) : 0
  const errorPercent = total > 0 ? Math.round((error / total) * 100) : 0
  const successRate = total > 0 ? Math.round((sent / (sent + error)) * 100) : 0

  stats.value = {
    sent,
    pending,
    error,
    total,
    sentPercent,
    pendingPercent,
    errorPercent,
    successRate,
    todayEmails: Math.floor(Math.random() * 10) + 5,
    avgProcessTime: Math.floor(Math.random() * 10) + 2,
    activeUsers: Math.floor(Math.random() * 5) + 1
  }
}

onMounted(async () => {
  try {
    await emailsStore.fetchEmails()
    calculateStats()
  } catch (error) {
    console.error('Error fetching emails for dashboard:', error)
  } finally {
    loading.value = false
  }
})
</script>