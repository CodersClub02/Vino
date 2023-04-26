<script setup>
/**
 * @author Saddek, Hanane
 */
import { useAuthStore } from "../stores/auth";
const authStore = useAuthStore()

import Entete from "../components/Entete.vue";
import ListeCelliers from "../components/ListeCelliers.vue";
import Connexion from "../components/Connexion.vue";

</script>

<template>
  <Entete :titre='authStore.user ? "Liste des celliers" : " Se connecter"' />
  <main>
    <ListeCelliers v-if="authStore.user" />
    <Connexion v-else />
  </main>
</template>