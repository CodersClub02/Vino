import { createRouter, createWebHistory } from "vue-router";

import { Accueil } from "../components/Accueil.vue";

const routes = [
    {path: "/", component: Accueil},
    {path: "/connecter", component: () => import("../components/Connecter.vue")},
    {path: "/creer-compte", component: () => import("../components/Inscrire.vue")}
]

const router = createRouter({
    history: createWebHistory,
    routes
})

export default router