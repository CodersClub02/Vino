<script setup>
/**
 * @author Saddek, Hanane
 */
import { useAuthStore } from "../stores/auth";
const authStore = useAuthStore()

import Entete from "../components/Entete.vue";
import Cellier from "../components/Cellier.vue";
import Connexion from "../components/Connexion.vue";

</script>

<template>
  <Entete :titre='authStore.user ? "Liste des ...": " Se connecter"' />
  <main>
    <Cellier v-if="authStore.user" />
    <Connexion v-else />
  </main>
</template>