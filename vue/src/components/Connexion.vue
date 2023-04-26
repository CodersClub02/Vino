<script setup>
import { ref } from "vue";
import { useAuthStore } from "../stores/auth";

import Input from "../components/Input.vue";
import Button from "../components/Button.vue";

const authStore = useAuthStore()

/**
 * @description initialisation des données usager, pour éviter la saisie pendant la phase de developement
 */
const form = ref({
    courriel: 'test@example.com',
    mot_de_passe: 'password'
})

</script>

<template>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <h2 class="text-rose-800 mt-10 text-center text-2xl font-bold leading-9 tracking-tight">Connecter à votre
                    compte
                </h2>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

                <form @submit.prevent="authStore.connecter(form)" class="space-y-6">

                    <Input v-bind:erreur="authStore.erreurs.email" v-model="form.courriel" label="Courriel" name="courriel"
                        type="email" autocomplete="email" />

                    <Input v-bind:erreur="authStore.erreurs.password" v-model="form.mot_de_passe" label="Mot de passe"
                        name="mot_de_passe" type="password">
                    <router-link :to="{ name: 'CreerCompte' }" class="font-semibold text-rose-800 hover:text-red-500">Mot de
                        passe
                        oublié?</router-link>
                    </Input>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-rose-800 px-3 p-3 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-800">Se
                            connecter</button>
                    </div>
                </form>

                <p class="mt-10 text-center text-sm text-gray-500">
                    Non inscrit?<router-link :to="{ name: 'CreerCompte' }"
                        class="font-semibold leading-6 text-rose-800 hover:text-red-500">Créez votre compte</router-link>
                </p>

            </div>
        </div>
    </div>
</template>