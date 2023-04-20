<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "../stores/auth";

const authStore = useAuthStore();

onMounted( async()=>{
  await authStore.getUser()
})

</script>

<template>
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold tracking-tight text-gray-900">Accueil</h1>
        </div>
    </header>
    <main>
       <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
         <!-- Your content -->
       </div>
    </main>
</template>