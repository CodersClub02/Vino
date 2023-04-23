<script setup>
/**
 * @author Saddek
 */
import { ref } from "vue";
import { useAuthStore } from "../stores/auth";
import Input from "../components/Input.vue";
<<<<<<< HEAD
=======
import Button from "../components/Button.vue";
>>>>>>> 6938cc2ae3519c87be223804173647659ace7f21

const authStore = useAuthStore();

/**
 * @description initialisation des données usager, pour éviter la saisie pendant la phase de developement
 */
const form = ref({
  courriel: 'test@example.com',
  mot_de_passe: 'password'
})
</script>

<template>
  <header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900">Accueil</h1>
    </div>
  </header>

  <main>
    <div v-if="authStore.user">
      this is welcome
    </div>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8" v-else>
      <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
          <h2 class="text-rose-800 mt-10 text-center text-2xl font-bold leading-9 tracking-tight">Entrez à votre compte
          </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

          <form @submit.prevent="authStore.connecter(form)" class="space-y-6">

                  <Input
                  v-bind:erreur="authStore.erreurs.email"
                  v-model="form.courriel"
                  label="Courriel"
                  name="courriel"
                  type="email"
                  autocomplete="email"
                  />

                  <Input 
                  v-bind:erreur="authStore.erreurs.password"
                  v-model="form.mot_de_passe"
                  label="Mot de passe"
                  name="mot_de_passe"
                  type="password"
                  >
                    <router-link :to="{ name: 'CreerCompte' }" class="font-semibold text-rose-800 hover:text-red-500">Mot de passe oublié?</router-link>
                  </Input>
                  
            <div>
              <button type="submit"
                class="flex w-full justify-center rounded-md bg-rose-800 px-3 p-3 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-800">Entrez</button>
            </div>
          </form>

          <p class="mt-10 text-center text-sm text-gray-500">
            Non inscrit?<router-link :to="{ name: 'CreerCompte' }"
              class="font-semibold leading-6 text-rose-800 hover:text-red-500">Créez votre compte</router-link>
          </p>

        </div>
      </div>
    </div>



  </main>

  <div class="relative isolate overflow-hidden bg-white px-6 py-24 sm:py-32 lg:overflow-visible lg:px-0">
    <div class="absolute inset-0 -z-10 overflow-hidden">
      <svg
        class="absolute left-[max(50%,25rem)] top-0 h-[64rem] w-[128rem] -translate-x-1/2 stroke-gray-200 [mask-image:radial-gradient(64rem_64rem_at_top,white,transparent)]"
        aria-hidden="true">
        <defs>
          <pattern id="e813992c-7d03-4cc4-a2bd-151760b470a0" width="200" height="200" x="50%" y="-1"
            patternUnits="userSpaceOnUse">
            <path d="M100 200V.5M.5 .5H200" fill="none" />
          </pattern>
        </defs>
        <svg x="50%" y="-1" class="overflow-visible fill-gray-50">
          <path d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M-300.5 600h201v201h-201Z"
            stroke-width="0" />
        </svg>
        <rect width="100%" height="100%" stroke-width="0" fill="url(#e813992c-7d03-4cc4-a2bd-151760b470a0)" />
      </svg>
    </div>
    <div
      class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-2 lg:items-start lg:gap-y-10">
      <div
        class="lg:col-span-2 lg:col-start-1 lg:row-start-1 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
        <div class="lg:pr-4">
          <div class="lg:max-w-lg">
            <p class="text-base font-semibold leading-7 text-indigo-600">Deploy faster</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">A better workflow</h1>
            <p class="mt-6 text-xl leading-8 text-gray-700">Aliquet nec orci mattis amet quisque ullamcorper neque, nibh
              sem. At arcu, sit dui mi, nibh dui, diam eget aliquam. Quisque id at vitae feugiat egestas.</p>
          </div>
        </div>
      </div>
      <div
        class="lg:col-span-2 lg:col-start-1 lg:row-start-2 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
        <div class="lg:pr-4">
          <div class="max-w-xl text-base leading-7 text-gray-700 lg:max-w-lg">
            <ul role="list" class="mt-8 space-y-8 text-gray-600">
              <li class="flex gap-x-3">
                <span><strong class="font-semibold text-gray-900">Push to deploy.</strong> Lorem ipsum, dolor sit amet
                  consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor cupiditate
                  blanditiis ratione.</span>
              </li>
              <li class="flex gap-x-3">
                <span><strong class="font-semibold text-gray-900">SSL certificates.</strong> Anim aute id magna aliqua ad
                  ad non deserunt sunt. Qui irure qui lorem cupidatat commodo.</span>
              </li>
              <li class="flex gap-x-3">
                <span><strong class="font-semibold text-gray-900">Database backups.</strong> Ac tincidunt sapien vehicula
                  erat auctor pellentesque rhoncus. Et magna sit morbi lobortis.</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>