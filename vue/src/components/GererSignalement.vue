<script setup>
/**
 * @author Hanane
 * @description Formulaire ajout de bouteille
 */

import { onMounted } from 'vue';
import { useAdminStore } from '../stores/admin'
import { useAppStore } from '../stores/app'
import Button from "../components/Button.vue"
import SecButton from "../components/SecButton.vue"
import Input from "../components/Input.vue"
import Select from './Select.vue';
import Textarea from './Textarea.vue';

const adminStore = useAdminStore()
const appStore = useAppStore()

onMounted(async () => {
    await appStore.getListeType();
    await appStore.getListePays();
})

</script>

<template>
    <div class="mx-auto w-full max-w-lg bg-white flex gap-10 flex-col justify-center p-6">

        <header class="flex flex-col">
            <span>{{ adminStore.bouteilleACorriger.name }}</span>
            <span>{{ adminStore.bouteilleACorriger.message }}</span>
        </header>


        <form @submit.prevent="adminStore.resoudreErreur()" class="flex gap-16 flex-col mx-auto w-full">

            <Input v-bind:erreur="adminStore.erreursBouteilleAcorriger.nom" v-model="adminStore.bouteilleACorriger.nom" label="Nom de bouteille" name="nom" type="text" />

            <Input v-bind:erreur="adminStore.erreursBouteilleAcorriger.code_saq" v-model="adminStore.bouteilleACorriger.code_saq" label="Code saq" name="code_saq" type="text" />

            <Textarea v-bind:erreur="adminStore.erreursBouteilleAcorriger.description_saq" v-model="adminStore.bouteilleACorriger.description_saq" label="Déscription saq" name="description_saq" />

            <Select v-model="adminStore.bouteilleACorriger.type_id" :options="appStore.listeType"
                v-bind:erreur="adminStore.erreursBouteilleAcorriger.type_id" label="Type" />

            <Select v-model="adminStore.bouteilleACorriger.pays_id" :options="appStore.listePays"
                v-bind:erreur="adminStore.erreursBouteilleAcorriger.pays_id" label="Pays" />


            <Input v-bind:erreur="adminStore.erreursBouteilleAcorriger.format" v-model="adminStore.bouteilleACorriger.format"
                label="Format" name="format" type="text" />

            <Input v-bind:erreur="adminStore.erreursBouteilleAcorriger.url_image_saq"
                v-model="adminStore.bouteilleACorriger.url_image_saq" label="url image" name="url_image_saq"
                type="text"/>

            <Input v-bind:erreur="adminStore.erreursBouteilleAcorriger.url_saq"
                v-model="adminStore.bouteilleACorriger.url_saq" label="url image" name="url_saq"
                type="text"/>

            <Input v-bind:erreur="adminStore.erreursBouteilleAcorriger.prix_saq" v-model="adminStore.bouteilleACorriger.prix_saq"
                label="Prix saq" name="prix_saq" type="number" step=".01" />

            <div class="flex gap-4 justify-between">
                <Button texteBouton="Sauvegarder" />
                <SecButton texteBouton="Annuler" @click="togglerFormSignalement(), this.togglerFormSignalement()" class="bg-gray-400 text-gray-900" />
            </div>

        </form>

    </div>
</template>