<script setup>

/**
 * @author Hanane
 * @description Formulaire ajout d'un cellier'
 */

import { useAppStore } from '../stores/app'
import Button from "../components/Button.vue"
import Input from "../components/Input.vue"

const appStore = useAppStore()
defineProps({
    form:{
        type: Object,
    }
})

</script>

<template>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">

            <form @submit.prevent="appStore.ajouterCellier(form)" class="space-y-6">

                <Input v-bind:erreur="appStore.erreursCellier.nom" v-model="form.nom" label="Nom" name="nom" type="text" />

                <div class="flex gap-4 justify-between">
                    <Button texteBouton="Sauvegarder" />
                    <Button texteBouton="Annuler" @click="$emit('cacherForm')" class="bg-gray-400 text-gray-900" />
                </div>

            </form>

        </div>
    </div>
</template>



