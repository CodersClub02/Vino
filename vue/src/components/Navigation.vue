<script setup>
/**
 * @author Saddek
 * @description Vue de navigation principale de l'application
 */

import { useAuthStore } from "../stores/auth";
const authUsager = useAuthStore();


</script>

<template>

<header class="flex items-baseline justify-between bg-black p-3">

  <router-link :to="{ name: 'Accueil' }">
    <img class="h-14" src="/vino-logo.png" alt="Vino" />
  </router-link>

  <router-link :to="{ name: 'Profil' }" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']" v-if="authUsager.user">
    Mon Profil {{ authUsager.user.name }}
  </router-link>

  <button @click="authUsager.deconnecter()" class="block px-4  text-sm text-gray-700" v-if="authUsager.user">
    Déconnecter
  </button>

  <router-link :to="{ name: 'CreerCompte' }" class="block px-4 py-2 text-sm text-gray-700" v-if="!authUsager.user">S'inscrire</router-link>
</header>

</template>