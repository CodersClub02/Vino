<script setup>
/**
 * @author Saddek, Hanane
 */
import { useAuthStore } from "../stores/auth";
const authStore = useAuthStore()

import Cellier from "../components/Cellier.vue";
import Connexion from "../components/Connexion.vue";
import AdminZone from "../components/AdminZone.vue";

</script>

<template>
    <main class="relative pb-32 min-h-screen">

        <AdminZone v-if="authStore.user?.est_admin" />
        <Cellier v-else-if="authStore.user" />
        <Connexion v-else />
    </main>
</template>