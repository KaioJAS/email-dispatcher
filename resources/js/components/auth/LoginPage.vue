<script setup>
import { ref } from "vue";
import { useAuthStore } from "../../stores/auth";

const authStore = useAuthStore();

const form = ref({
  email: "",
  password: "",
});

const errors = ref({});
const errorMessage = ref("");

const handleLogin = async () => {
  clearErrors();

  if (!validateForm()) {
    return;
  }

  const result = await authStore.login(form.value);

  if (!result.success) {
    errorMessage.value = result.message || "Erro no login";
  }
};

const validateForm = () => {
  let valid = true;

  if (!form.value.email) {
    errors.value.email = "Email é obrigatório";
    valid = false;
  }

  if (!form.value.password) {
    errors.value.password = "Senha é obrigatória";
    valid = false;
  }

  return valid;
};

const clearErrors = () => {
  errors.value = {};
  errorMessage.value = "";
};
</script>

<template>
  <div
    class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
  >
    <div class="max-w-md w-full space-y-8">
      <div class="bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
          <h2 class="text-3xl font-bold text-gray-900">Teste Greenn</h2>
          <p class="mt-2 text-sm text-gray-600">Faça login para continuar</p>
        </div>

        <form @submit.prevent="handleLogin" class="space-y-6">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
              Email
            </label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              :class="{ 'border-red-300': errors.email }"
              placeholder="seu@email.com"
            />
            <p v-if="errors.email" class="mt-1 text-sm text-red-600">
              {{ errors.email }}
            </p>
          </div>

          <div>
            <label
              for="password"
              class="block text-sm font-medium text-gray-700"
            >
              Senha
            </label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              :class="{ 'border-red-300': errors.password }"
              placeholder="Digite sua senha"
            />
            <p v-if="errors.password" class="mt-1 text-sm text-red-600">
              {{ errors.password }}
            </p>
          </div>

          <div v-if="errorMessage" class="rounded-md bg-red-50 p-4">
            <p class="text-sm text-red-800">{{ errorMessage }}</p>
          </div>

          <div>
            <button
              type="submit"
              :disabled="authStore.loading"
              class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {{ authStore.loading ? "Entrando..." : "Entrar" }}
            </button>
          </div>
        </form>

        <div class="mt-6 text-center">
          <p class="text-xs text-gray-500">Use: admin@test.com / 123456</p>
        </div>
      </div>
    </div>
  </div>
</template>
