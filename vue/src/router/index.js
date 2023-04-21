import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../stores/auth";

//() => import(".. lazyload components...
const routes = [
    { path: "/", name: "Accueil", component: () => import("../components/Accueil.vue") },
    { path: "/creer-compte", name: "CreerCompte", component: () => import("../components/Inscrire.vue") },
    { path: "/profil", name: "Profil", component: () => import("../components/Profil.vue") },
    { path: "/ajouter-bouteille", name: "AjouterBouteille", component: () => import("../components/AjouterBouteille.vue") },
    { path: '/:pathMatch(.*)*', name: 'not-found', component: () => import("../components/pageNonExistante.vue") },
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