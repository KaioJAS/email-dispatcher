import { defineStore } from 'pinia'
import apiClient from '../services/axios'

export const useEmailsStore = defineStore('emails', {
  state: () => ({
    emails: [],
    loading: false,
    totalRecords: 0,
    currentPage: 1,
    perPage: 15
  }),

  getters: {
    emailsByStatus: (state) => (status) => {
      return state.emails.filter(email => email.status === status)
    },
    
    totalEmails: (state) => state.totalRecords,
    
    pendingEmails: (state) => state.emails.filter(email => email.status === 'pendente').length,
    
    sentEmails: (state) => state.emails.filter(email => email.status === 'enviado').length,
    
    errorEmails: (state) => state.emails.filter(email => email.status === 'erro').length
  },

  actions: {
    async fetchEmails(page = 1) {
      this.loading = true
      
      try {
        const response = await apiClient.get(`/emails?page=${page}&per_page=${this.perPage}`)
        const data = response.data
        if (data.success) {
          this.emails = data.data.data || []
          this.totalRecords = data.data.meta.total || 0
          this.currentPage = data.data.meta.current_page || 1
          this.lastPage = data.data.meta.last_page || 1
        }
      } catch (error) {
        console.error('Fetch emails error:', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    async createEmail(emailData) {
      this.loading = true
      
      try {
        const response = await apiClient.post('/emails', emailData)
        const data = response.data
        
        if (data.success) {
          this.fetchEmails(1) 
          return { success: true, data: data.data }
        }
        
        return { success: false, message: data.message }
      } catch (error) {
        console.error('Create email error:', error)
        const message = error.response?.data?.message || 'Erro ao criar email'
        return { success: false, message }
      } finally {
        this.loading = false
      }
    },

    async deleteEmail(emailId) {
      try {
        const response = await apiClient.delete(`/emails/${emailId}`)
        const data = response.data
        
        if (data.success) {
          this.fetchEmails(this.currentPage)
          return { success: true }
        }
        
        return { success: false, message: data.message }
      } catch (error) {
        console.error('Delete email error:', error)
        const message = error.response?.data?.message || 'Erro ao deletar email'
        return { success: false, message }
      }
    }
  }
})