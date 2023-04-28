<script setup>
/**
 * @author Hanane
 * @description Formulaire ajout de bouteille
 */

import { ref } from 'vue';
import { useAppStore } from '../stores/app'
import Button from "../components/Button.vue"
import Input from "../components/Input.vue"
import Textarea from "../components/Textarea.vue"

const appStore = useAppStore()
const form = ref({
    bouteille_id: null,
    cellier_id: props.cellierId,
    date_achat: null,
    garder_jusqu_a: null,
    notes: null,
    prix_paye: null,
    quantite: null,
    mellisme: null,
});

const props = defineProps({
    cellierId: {
        type: Number
    }
})
</script>

<template>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 bg-white">
        <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Ajouter bouteille
                </h2>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form @submit.prevent="appStore.ajouterBouteille(form)" class="space-y-6">

                    <Input v-bind:erreur="appStore.erreursBouteille.bouteille_id" v-model="form.bouteille_id" label="Nom"
                        name="bouteille_id" type="text" />

                    <Textarea v-bind:erreur="appStore.erreursBouteille.notes" v-model="form.notes" label="Notes"
                        name="notes" />

                    <Input v-bind:erreur="appStore.erreursBouteille.quantite" v-model="form.quantite" label="Quantité"
                        name="quantite" type="number" min="1" />


                    <Input v-bind:erreur="appStore.erreursBouteille.mellisme" v-model="form.mellisme" label="Méllisme"
                        name="mellisme" type="number" />

                    <Input v-bind:erreur="appStore.erreursBouteille.date_achat" v-model="form.date_achat"
                        label="Date d'achat" name="date_achat" type="date" />

                    <Input v-bind:erreur="appStore.erreursBouteille.garder_jusqu_a" v-model="form.garder_jusqu_a"
                        label="Garder jusqu'à" name="garder_jusqu_a" type="date" />

                    <Input v-bind:erreur="appStore.erreursBouteille.prix_paye" v-model="form.prix_paye" label="Prix"
                        name="prix_paye" type="number" />

                    <div class="flex gap-4 justify-between">
                        <Button texteBouton="Sauvegarder" />
                        <Button texteBouton="Annuler" @click="$emit('cacherForm')" class="bg-gray-400 text-gray-900" />
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>