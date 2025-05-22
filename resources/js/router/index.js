import { createRouter, createWebHashHistory } from "vue-router";
import { useAuthStore } from "../stores/auth";

const Dashboard = () => import("../components/modules/dashboard/Dashboard.vue");
const EmailControl = () => import("../components/modules/emails/EmailControl.vue");

const routes = [
  {
    path: "/",
    name: "dashboard",
    component: Dashboard,
    meta: {
      title: "Dashboard",
      requiresAuth: true,
    },
  },
  {
    path: "/emails",
    name: "emails",
    component: EmailControl,
    meta: {
      title: "Controle de Emails",
      requiresAuth: true,
    },
  },
  {
    path: "/:pathMatch(.*)*",
    redirect: "/",
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();

  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next(false);
    return;
  }

  document.title = `${to.meta.title} - Teste Greenn`;

  next();
});

export default router;
