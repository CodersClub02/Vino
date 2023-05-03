<script setup>
  import { useAuthStore } from "./stores/auth";
  const authStore = useAuthStore()

import Navigation from "./components/Navigation.vue";

</script>
<template>
  <div v-if="authStore.erreurServeur" class="flex justify-center items-center fixed top-20 left-0 bg-red-500 text-yellow-100 w-full h-48">
    ERROR API
  </div>
  <Navigation />
  <RouterView />
</template>
