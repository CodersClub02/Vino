<script setup>

/**
 * @author Hanane
 * @description Formulaire ajout d'un cellier'
 */

import { ref } from 'vue';
import { useAuthStore } from '../stores/auth'
import Button from "../components/Button.vue"
import Input from "../components/Input.vue"

const authStore = useAuthStore()
const form = ref({
    nom: ''
})

</script>

<template>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

                <form @submit.prevent="authStore.ajouterCellier(form)" class="space-y-6">

                    <Input v-bind:erreur="authStore.erreurs.name" v-model="form.nom" label="Nom" name="nom" type="text" />

                    <Button texteBouton="Sauvegarder" />

                </form>

            </div>
        </div>
    </div>
</template>



