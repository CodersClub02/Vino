<script setup>
import Navigation from "./components/Navigation.vue";

import { onMounted } from "vue";
import { useAuthStore } from "./stores/auth";
const authStore = useAuthStore();
onMounted( async()=>{
  await authStore.getUser()
})

</script>
<template>
  <Navigation />
  <RouterView />
</template>
