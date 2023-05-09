<script setup>
/**
 * @author Hanane
 * @description Formulaire ajout usager
 */
import { ref } from 'vue';
import { useAuthStore } from '../stores/auth'
import Input from "../components/Input.vue";
import Button from "../components/Button.vue";


const authStore = useAuthStore()
const form = ref({
    nom: '',
    courriel: '',
    mot_de_passe: '',
    confirmer_mot_de_passe: ''
});

</script>

<template>
    <main>
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Créer votre
                        compte</h2>
                </div>

                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form @submit.prevent="authStore.creerCompte(form)" class="space-y-6">

                        <Input v-bind:erreur="authStore.erreurs.name" v-model="form.nom" label="Nom" name="nom"
                            type="text" />

                        <Input v-bind:erreur="authStore.erreurs.email" v-model="form.courriel" label="Courriel"
                            name="courriel" type="email" autocomplete="email" />

                        <Input v-bind:erreur="authStore.erreurs.password" v-model="form.mot_de_passe" label="Mot de passe"
                            name="mot_de_passe" type="password" />

                        <Input v-bind:erreur="authStore.erreurs.password_confirmation" v-model="form.confirmer_mot_de_passe"
                            label="confirmer votre mot de passe" name="confirmer_mot_de_passe" type="password" />

                        <Button texteBouton="S'inscrire" />

                    </form>

                    <p class="mt-10 text-center text-sm text-gray-500">
                        Vous avez un compte?
                        {{ ' ' }}

                        <router-link :to="{ name: 'Accueil' }"
                            class="font-semibold leading-6 text-rose-800 hover:text-indigo-500">Cliquez ici</router-link>
                    </p>
                </div>
            </div>
        </div>
    </main>
</template>