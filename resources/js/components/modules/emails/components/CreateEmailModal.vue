<template>
  <div
    v-if="visible"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
    @click="closeModal"
  >
    <div
      class="relative top-20 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white"
      @click.stop
    >
      <div class="flex items-center justify-between border-b pb-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900">
          Crie seu novo disparo
        </h3>
        <button
          @click="closeModal"
          class="text-gray-400 hover:text-gray-600 transition-colors"
        >
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>

      <form @submit.prevent="handleSubmit" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label
              for="titulo"
              class="block text-sm font-medium text-gray-700 mb-2"
            >
              Título
            </label>
            <InputText
              id="titulo"
              v-model="form.titulo"
              placeholder="  Preencha o título do email"
              class="w-full text-lg py-2"
              :class="{ 'p-invalid': errors.titulo }"
              size="large"
            />
            <small v-if="errors.titulo" class="p-error">{{
              errors.titulo
            }}</small>
          </div>

          <div>
            <label
              for="remetente"
              class="block text-sm font-medium text-gray-700 mb-2"
            >
              E-mail do remetente
            </label>
            <InputText
              id="remetente"
              v-model="form.remetente"
              type="email"
              placeholder="  remetente@mail.com"
              class="w-full text-lg py-2"
              :class="{ 'p-invalid': errors.remetente }"
              size="large"
            />
            <small v-if="errors.remetente" class="p-error">{{
              errors.remetente
            }}</small>
          </div>
        </div>

        <div>
          <label
            for="destinatarios"
            class="block text-sm font-medium text-gray-700 mb-2"
          >
            E-mails dos destinatários
          </label>
          <Textarea
            id="destinatarios"
            v-model="form.destinatarios"
            rows="3"
            placeholder="  Insira os e-mails separados por vírgula&#10;&#10;  ex: example@org.br,example2@teste.com"
            class="w-full"
            :class="{ 'p-invalid': errors.destinatarios }"
          />
          <small v-if="errors.destinatarios" class="p-error">{{
            errors.destinatarios
          }}</small>
        </div>

        <div class="pb-8">
          <label
            for="conteudo"
            class="block text-sm font-medium text-gray-700 mb-2"
          >
            Conteúdo do e-mail
          </label>

          <Editor
            v-model="form.conteudo"
            :style="{ height: '200px', border: errors.conteudo ? '1px solid red' : '' }"
            :class="{ 'p-invalid': errors.conteudo }"
            placeholder="Escreva o conteúdo do seu email aqui..."
          />
        </div>
          <small v-if="errors.conteudo" class="p-error pt-8">{{
            errors.conteudo
          }}</small>

        <div class="flex justify-end space-x-3 pt-5">
          <Button
            type="button"
            @click="closeModal"
            label="Cancelar"
            severity="secondary"
            outlined
            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          />
          <Button
            type="submit"
            :loading="loading"
            :label="loading ? 'Criando...' : 'Criar agora'"
            :disabled="loading"
            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 disabled:opacity-50"
          />
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { useEmailsStore } from "../../../../stores/emails";

const props = defineProps({
  visible: Boolean,
});

const emit = defineEmits(["update:visible", "email-created"]);

const emailsStore = useEmailsStore();

const form = ref({
  titulo: "",
  remetente: "",
  destinatarios: "",
  conteudo: "",
});

const errors = ref({});
const loading = ref(false);

const validateForm = () => {
  errors.value = {};

  if (!form.value.titulo.trim()) {
    errors.value.titulo = "O título é obrigatório";
  }

  if (!form.value.remetente.trim()) {
    errors.value.remetente = "O email do remetente é obrigatório";
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.value.remetente)) {
    errors.value.remetente = "Email do remetente inválido";
  }

  if (!form.value.destinatarios.trim()) {
    errors.value.destinatarios = "Os destinatários são obrigatórios";
  }

  const contentText = form.value.conteudo.replace(/<[^>]*>/g, "").trim();
  if (!contentText) {
    errors.value.conteudo = "O conteúdo é obrigatório";
  }

  return Object.keys(errors.value).length === 0;
};

const handleSubmit = async () => {
  if (!validateForm()) {
    return;
  }

  loading.value = true;

  try {
    const result = await emailsStore.createEmail(form.value);

    if (result.success) {
      emit("email-created");
      resetForm();
    } else {
      if (result.errors) {
        errors.value = result.errors;
      } else {
        errors.value.general = result.message || 'Erro ao criar email'
      }
    }
  } catch (error) {
    errors.value.general = 'Erro ao criar email. Tente novamente.'
    console.error("Error creating email:", error);
  } finally {
    loading.value = false;
  }
};

const closeModal = () => {
  if (!loading.value) {
    emit("update:visible", false);
    resetForm();
  }
};

const resetForm = () => {
  form.value = {
    titulo: "",
    remetente: "",
    destinatarios: "",
    conteudo: "",
  };
  errors.value = {};
};

watch(
  () => props.visible,
  (newVal) => {
    if (!newVal) {
      resetForm();
    }
  }
);
</script>

<style>
.p-editor-toolbar {
  border-top-left-radius: 6px;
  border-top-right-radius: 6px;
}

.p-editor-content {
  border-bottom-left-radius: 6px;
  border-bottom-right-radius: 6px;
}

.p-invalid .p-editor-container {
  border-color: #e24c4c;
}

.p-error {
  color: #e24c4c;
  font-size: 0.875rem;
  margin-top: 0.25rem;
  display: block;
}

.p-inputtext {
  border: 1px solid #e2e8f0 !important;
  border-radius: 0.375rem !important;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
  transition: all 0.3s ease !important;
}

.p-inputtext:hover {
  border-color: #cbd5e1 !important;
}

.p-inputtext:focus {
  border-color: #667eea !important;
  box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.25) !important;
}

.p-inputtext.p-invalid {
  border-color: #e24c4c !important;
}

</style>
