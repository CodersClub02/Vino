<script setup>
/**
 * @author Saddek, Hanane
 */
import { useAuthStore } from "../stores/auth";
const authStore = useAuthStore()

import Cellier from "../components/Cellier.vue";
import Connexion from "../components/Connexion.vue";

</script>

<template>

<main class="pb-32">
    <Cellier v-if="authStore.user" />
    <Connexion v-else />
</main>

</template>