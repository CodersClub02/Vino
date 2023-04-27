/**
 * @author Hanane, Saddek
 * @description gestion des url de l'application sur le navigateur
 */

import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../stores/auth";

//() => import(".. lazyload vues...
const routes = [
    { path: "/", name: "Accueil", component: () => import("../vues/Accueil.vue") },
    { path: "/creer-compte", name: "CreerCompte", component: () => import("../vues/Inscrire.vue") },
    { path: "/profil", name: "Profil", component: () => import("../vues/Profil.vue") },
    { path: '/:pathMatch(.*)*', name: 'not-found', component: () => import("../vues/PageIntrouvable.vue") },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

/**
 * @author Saddek
 * @description protection des pages avec authentification
 * evidement le serveur API doit aussi enforcer ces mesures puisque il est
 * l'ultime gardien
 */
router.beforeEach(async (to, from) => {
    //confirmer que l'usager n'est pas connecté avant de procéder
    const authStore = useAuthStore();
    await authStore.getUser()
    if (!authStore.user && (to.name != "Accueil" && to.name != "CreerCompte")) {
        if (!authStore.user) router.push({ name: 'Accueil' });
    }
});

export default router