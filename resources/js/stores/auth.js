import { defineStore } from 'pinia'
import apiClient from '../services/axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null,
    isAuthenticated: false,
    loading: false
  }),

  getters: {
    userName: (state) => state.user?.name || '',
    userEmail: (state) => state.user?.email || '',
    bearerToken: (state) => state.token ? `Bearer ${state.token}` : null
  },

  actions: {
    async login(credentials) {
      this.loading = true
      
      try {
        const response = await apiClient.post('/auth/login', credentials)
        const data = response.data

        if (data.success) {
          this.user = data.user
          this.token = data.token
          this.isAuthenticated = true
          
          localStorage.setItem('user', JSON.stringify(data.user))
          localStorage.setItem('token', data.token)
          localStorage.setItem('isAuthenticated', 'true')
          
          return { success: true }
        } else {
          return { success: false, message: data.message }
        }
      } catch (error) {
        console.error('Login error:', error)
        const message = error.response?.data?.message || 'Erro de conexão'
        return { success: false, message }
      } finally {
        this.loading = false
      }
    },

    async logout() {
      try {
        await apiClient.post('/auth/logout')
      } catch (error) {
        console.error('Logout error:', error)
      }

      this.user = null
      this.token = null
      this.isAuthenticated = false
      localStorage.removeItem('user')
      localStorage.removeItem('token')
      localStorage.removeItem('isAuthenticated')
    },

    async checkAuth() {
      const savedUser = localStorage.getItem('user')
      const savedToken = localStorage.getItem('token')
      const savedAuth = localStorage.getItem('isAuthenticated')

      if (savedUser && savedToken && savedAuth === 'true') {
        this.user = JSON.parse(savedUser)
        this.token = savedToken
        this.isAuthenticated = true

        try {
          const response = await apiClient.get('/auth/me')
          if (!response.data.success) {
            this.logout()
          }
        } catch (error) {
          console.error('Auth check error:', error)
          this.logout()
        }
      }
    },

    initialize() {
      this.checkAuth()
    }
  }
})