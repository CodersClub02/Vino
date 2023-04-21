import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../stores/auth";

//() => import(".. lazyload components...
const routes = [
    {path: "/", name: "Accueil", component: () => import("../components/Accueil.vue")},
    {path: "/connecter", name: "Connecter", component: () => import("../components/Connecter.vue")},
    {path: "/creer-compte", name: "CreerCompte", component: () => import("../components/Inscrire.vue")},
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach(async (to, from) => {
    const authStore = useAuthStore();
    console.log(authStore.user);
    // use authStore Here
});

export default router