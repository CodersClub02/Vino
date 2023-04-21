import { createRouter, createWebHistory } from "vue-router";

import Accueil from "../components/Accueil.vue";

const routes = [
    { path: "/", name: "Accueil", component: Accueil },
    { path: "/connecter", name: "Connecter", component: () => import("../components/Connecter.vue") },
    { path: "/creer-compte", name: "CreerCompte", component: () => import("../components/Inscrire.vue") },
    { path: "/profil", name: "Profil", component: () => import("../components/Profil.vue") },
    { path: "/ajouter-bouteille", name: "AjouterBouteille", component: () => import("../components/AjouterBouteille.vue") },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router