<script setup>

/**
 * @author Hanane
 * @description Formulaire ajout d'un cellier'
 */

import { useAppStore } from '../stores/app'
import Button from "../components/Button.vue"
import SecButton from "../components/SecButton.vue"
import Input from "../components/Input.vue"

const appStore = useAppStore()
defineProps({
    form: {
        type: Object,
    }
})

</script>

<template>

    <form @submit.prevent="appStore.gererCellier(form)" class="flex flex-col gap-6 justify-center px-6 py-16 w-full max-w-sm mx-auto">

        <Input v-bind:erreur="appStore.erreursCellier.nom" v-model="form.nom" label="Nom de cellier" name="nom" type="text" />

        <div class="flex gap-4 justify-between">
            <Button texteBouton="Sauvegarder" />
            <SecButton texteBouton="Annuler" @click="$emit('cacherForm')" class="bg-gray-400 text-gray-900" />
        </div>

    </form>

</template>