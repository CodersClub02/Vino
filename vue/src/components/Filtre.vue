<script setup>
/**
 * @author Saddek
 * @description Formulaire filtre de bouteille
 */

import { ref, onMounted } from 'vue';
import { useAppStore } from '../stores/app'
import Button from "../components/Button.vue"
import SecButton from "../components/SecButton.vue"
import Select from './Select.vue';

const appStore = useAppStore()

onMounted(async () => {
    await appStore.getListeType();
    await appStore.getListePays();
})

const filtre = ref({})
const tableauNotes = [{ id: 1, nom: '1 étoile' }, { id: 2, nom: '2 étoiles' }, { id: 3, nom: '3 étoiles' }, { id: 4, nom: '4 étoiles' }, { id: 5, nom: '5 étoiles' }]
</script>

<template>
    <div class="w-full fixed z-10 inset-0 bg-white flex justify-center items-center">

        <form
            @submit.prevent="appStore.getBouteillesFiltre(filtre), $emit('cacherFormFiltre')"
            class="flex gap-16 flex-col max-w-md w-full bg-white p-5">

            <Select v-model="filtre.notes" :options="tableauNotes" label="Notes" />

            <Select v-model="filtre.type_id" :options="appStore.listeType" label="Type" />

            <Select v-model="filtre.pays_id" :options="appStore.listePays" label="Pays" />
            
            <div class="flex gap-4 justify-between">
                <Button texteBouton="Appliquer" />
                <SecButton texteBouton="Annuler" @click="$emit('cacherFormFiltre')" class="bg-gray-400 text-gray-900" />
            </div>

        </form>

    </div>
</template>