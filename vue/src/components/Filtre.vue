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
</script>

<template>
    <div class="w-full bg-gray-900/10 fixed inset-0 flex justify-center items-center" @click.self="$emit('cacherFormFiltre')">

        <form
            @submit.prevent="appStore.getBouteillesFiltre(filtre), $emit('cacherFormFiltre')"
            class="flex gap-16 flex-col max-w-md w-full bg-white p-5">

            <Select v-model="filtre.type_id" :options="appStore.listeType" label="Type" />

            <Select v-model="filtre.pays_id" :options="appStore.listePays" label="Pays" />
            
            <div class="flex gap-4 justify-between">
                <Button texteBouton="Appliquer" />
                <SecButton texteBouton="Annuler" @click="$emit('cacherFormFiltre')" class="bg-gray-400 text-gray-900" />
            </div>

        </form>

    </div>
</template>