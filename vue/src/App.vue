<script setup>
import Navigation from "./components/Navigation.vue";
import { onMounted } from "vue";

/** importation de la store auth créé pour la gestion des données usager */
import { useAuthStore } from "./stores/auth";
const authStore = useAuthStore();
/** interoger le serveur dés l'affichage de la vue app */
onMounted( async()=>{
  await authStore.getUser()
})

</script>
<template>
  <Navigation />
  <RouterView />
</template>
