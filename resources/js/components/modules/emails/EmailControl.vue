<template>
  <div>
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-2xl font-semibold text-gray-900">Disparos</h1>
      <button
        @click="showCreateModal = true"
        class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
      >
        Criar novo disparo
      </button>
    </div>

    <div v-if="emailsStore.loading" class="flex justify-center py-8">
      <div class="text-gray-500">Carregando...</div>
    </div>

    <div v-else-if="emailsStore.emails.length === 0" class="text-center py-8">
      <div class="text-gray-500">Nenhum email encontrado</div>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="email in emailsStore.emails"
        :key="email.id"
        class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow-lg transition-shadow"
      >
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
          {{ email.titulo }}
        </h3>

        <div class="mb-3">
          <span class="text-sm text-gray-600">Remetente</span>
          <p class="text-sm text-gray-500">{{ email.remetente }}</p>
        </div>

        <div class="mb-3">
          <span class="text-sm text-gray-600">Status</span>
          <div class="flex items-center mt-1">
            <component
              :is="getStatusIcon(email.status)"
              :class="getStatusIconClass(email.status)"
              class="w-4 h-4 mr-2"
            />
            <span
              :class="getStatusTextClass(email.status)"
              class="text-sm font-medium"
            >
              {{ email.status_formatted }}
            </span>
          </div>
        </div>

        <div>
          <span class="text-sm text-gray-600">Modificado em</span>
          <p class="text-sm text-gray-500">{{ email.updated_at }}</p>
        </div>
      </div>
    </div>
    <div class="flex justify-center mt-8">
      <Paginator
        v-model:first="first"
        :rows="emailsStore.perPage"
        :totalRecords="emailsStore.totalRecords"
        :rowsPerPageOptions="[15, 30, 45]"
        @page="onPageChange($event)"
        :alwaysShow="true"
        template="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown CurrentPageReport"
        currentPageReportTemplate="{first} - {last} de {totalRecords}"
        class="border border-gray-200 rounded-lg mx-auto"
      />
    </div>

    <CreateEmailModal
      v-model:visible="showCreateModal"
      @email-created="handleEmailCreated"
    />

    <SuccessModal v-model:visible="showSuccessModal" />
  </div>
</template>

<script setup>
import { ref, onMounted, h } from "vue";
import { useEmailsStore } from "../../../stores/emails";
import CreateEmailModal from "./components/CreateEmailModal.vue";
import SuccessModal from "./components/SuccessModal.vue";

const emailsStore = useEmailsStore();
const showCreateModal = ref(false);
const showSuccessModal = ref(false);
const first = ref(0);

const getStatusIcon = (status) => {
  switch (status) {
    case "enviado":
      return () =>
        h(
          "svg",
          {
            fill: "none",
            stroke: "currentColor",
            viewBox: "0 0 24 24",
          },
          [
            h("path", {
              "stroke-linecap": "round",
              "stroke-linejoin": "round",
              "stroke-width": "2",
              d: "M5 13l4 4L19 7",
            }),
          ]
        );
    case "pendente":
      return () =>
        h(
          "svg",
          {
            fill: "none",
            stroke: "currentColor",
            viewBox: "0 0 24 24",
          },
          [
            h("path", {
              "stroke-linecap": "round",
              "stroke-linejoin": "round",
              "stroke-width": "2",
              d: "M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z",
            }),
          ]
        );
    case "erro":
      return () =>
        h(
          "svg",
          {
            fill: "none",
            stroke: "currentColor",
            viewBox: "0 0 24 24",
          },
          [
            h("path", {
              "stroke-linecap": "round",
              "stroke-linejoin": "round",
              "stroke-width": "2",
              d: "M6 18L18 6M6 6l12 12",
            }),
          ]
        );
    default:
      return () => h("div");
  }
};

const getStatusIconClass = (status) => {
  switch (status) {
    case "enviado":
      return "text-green-600";
    case "pendente":
      return "text-yellow-600";
    case "erro":
      return "text-red-600";
    default:
      return "text-gray-600";
  }
};

const getStatusTextClass = (status) => {
  switch (status) {
    case "enviado":
      return "text-green-700";
    case "pendente":
      return "text-yellow-700";
    case "erro":
      return "text-red-700";
    default:
      return "text-gray-700";
  }
};

const onPageChange = (event) => {
  const page = Math.floor(first.value / emailsStore.perPage) + 1;
  first.value = event.first;
  emailsStore.fetchEmails(page);
};

const handleEmailCreated = () => {
  showCreateModal.value = false;
  showSuccessModal.value = true;
  first.value = 0;
  emailsStore.fetchEmails(1);
};

onMounted(() => {
  emailsStore.fetchEmails();
});
</script>
