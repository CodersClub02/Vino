<script>
/**
 * @author Saddek
 * @description Si l'usager (ou bot) navigue vers une page qu'on a pas ...
 */
</script>
<template>
  <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
    <div class="text-center">

      <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Page introuvable</h1>
      <p class="mt-6 text-base leading-7 text-gray-600">Désolé!La page que vous cherchez n'existe pas.</p>
      <img src="/404.gif" alt="page introuvable">
      <div class="mt-10 flex items-center justify-center gap-x-6">
        <router-link :to="{ name: 'Accueil' }"
          class="rounded-md bg-rose-800 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-rose-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">Allez
          dans l'accueil</router-link>
      </div>
    </div>
  </main>
</template>
  