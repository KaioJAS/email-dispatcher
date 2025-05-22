<template>
  <div
    v-if="visible"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
    @click="closeModal"
  >
    <div
      class="relative top-20 mx-auto p-5 border w-11/12 max-w-md shadow-lg rounded-md bg-white"
      @click.stop
    >
      <div class="flex justify-end">
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

      <div class="text-center px-6 pb-6">
        <div
          class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100 mb-6"
        >
          <svg
            class="h-8 w-8 text-gray-600"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="1.5"
              d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
            />
          </svg>
        </div>

        <h3 class="text-2xl font-semibold text-gray-900 mb-2">
          Parabéns seu envio
        </h3>
        <h3 class="text-2xl font-semibold text-gray-900 mb-6">foi agendado</h3>

        <p class="text-gray-600 mb-8 leading-relaxed">
          Acompanhe as atualizações do seu envio na<br />
          listagem de disparos
        </p>

        <button
          @click="closeModal"
          class="px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Entendido
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  visible: Boolean,
});

const emit = defineEmits(["update:visible"]);

const closeModal = () => {
  emit("update:visible", false);
};
</script>
