<script setup>
/**
 * @author Saddek
 * @description Vue de navigation principale de l'application
 */


import { useAuthStore } from "../stores/auth";
const authUsager = useAuthStore();


</script>

<template>
  <header class="flex items-center justify-between bg-black p-3">

    <router-link :to="{ name: 'Accueil' }">
      <img class="h-14" src="/vino-logo.png" alt="Vino" />
    </router-link>


  <div class="flex">
    <router-link :to="{ name: 'Profil' }"
        :class="[active ? 'bg-gray-100' : '', 'flex flex-col gap-3 items-center px-4 py-2 text-sm text-white font-semibold']"
        v-if="authUsager.user">
        <font-awesome-icon icon="fa-solid fa-user" />
        Mon Profil
    </router-link>



    <button @click="authUsager.deconnecter()"
        :class="[active ? 'bg-gray-100' : '', 'flex flex-col gap-3 items-center px-4 py-2 text-sm text-white font-semibold']"
        v-if="authUsager.user">
        <font-awesome-icon icon="fa-solid fa-right-from-bracket" />
        Sortir
    </button>
  </div>

    <router-link :to="{ name: 'CreerCompte' }"
      :class="[active ? 'bg-gray-100' : '', 'flex flex-col gap-3 items-center px-4 py-2 text-sm text-white font-semibold']"
      v-if="!authUsager.user">
      <font-awesome-icon icon="fa-solid fa-user-plus" />
      S'inscrire
    </router-link>
  </header>
</template>