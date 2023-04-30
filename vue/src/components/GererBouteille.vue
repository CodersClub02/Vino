<script setup>
/**
 * @author Hanane
 * @description Formulaire ajout de bouteille
 */

import { ref, onMounted } from 'vue';
import { useAppStore } from '../stores/app'
import Button from "../components/Button.vue"
import SecButton from "../components/SecButton.vue"
import Input from "../components/Input.vue"
import Select from './Select.vue';
import Textarea from "../components/Textarea.vue"

const appStore = useAppStore()

onMounted(async () => {
    await appStore.getListeType();
    await appStore.getListePays();
})
const props = defineProps({

    cellier: {
        type: Object
    },

    formBouteille: {
        type: Object
    }

})

const afficherSuggestionsBouteilles = ref(false)
const tableauNotes = ['1 étoile', '2 étoiles', '3 étoiles', '4 étoiles', '5 étoiles']
</script>

<template>
    <div class="mx-auto max-w-7xl sm:px-6 bg-white flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Ajouter bouteille à
                {{ cellier.nomEnCours }}
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form @submit.prevent="appStore.ajouterBouteille(formBouteille)" class="space-y-6">

                <div>
                    <div class="flex items-center justify-between">
                        <label class="text-sm leading-6 text-gray-900 font-semibold">Source bouteille</label>
                    </div>

                    <div
                        class="mt-2 flex gap-6 w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6">
                        <label class="flex gap-2 text-sm leading-6 text-gray-900 ">
                            <input type="radio" class="form-radio accent-rose-600" name="source" value="saq"
                                v-model="formBouteille.source" checked>
                            la SAQ
                        </label>
                        <label class="flex gap-2 text-sm leading-6 text-gray-900 ">
                            <input type="radio" class="form-radio accent-rose-600" name="source" value="autre"
                                v-model="formBouteille.source">
                            Autre
                        </label>
                    </div>
                </div>

                <Input v-if="formBouteille.source == 'saq'" v-bind:erreur="appStore.erreursBouteille.bouteille_id"
                    v-model="formBouteille.nom" label="Code saq ou nom bouteille" type="text" autocomplete="off"
                    @input="appStore.listeSuggestionsBouteilles($event.target.value), afficherSuggestionsBouteilles = true">
                <template v-slot:liste>
                    <ul v-if="afficherSuggestionsBouteilles"
                        class="flex gap-3 flex-col absolute bg-slate-50 h-60 overflow-y-auto w-80 ">
                        <li v-for="bouteille in appStore.suggestionsBouteilles" @click="formBouteille.bouteille_id = bouteille.id,
                            formBouteille.nom = bouteille.nom,
                            afficherSuggestionsBouteilles = false" class="cursor-pointer w-full border-2 p-1">
                            {{ bouteille.nom }}
                        </li>
                    </ul>
                </template>

                </Input>
                <template v-if="formBouteille.source == 'autre'">

                    <Input v-bind:erreur="appStore.erreursBouteille.nom" v-model="formBouteille.nom"
                        label="Nom de bouteille" name="nom" type="text" />

                    <Input v-bind:erreur="appStore.erreursBouteille.format" v-model="formBouteille.format" label="Format"
                        name="format" type="text" />

                    <Select v-model="formBouteille.type_id" :options="appStore.listeType"
                        v-bind:erreur="appStore.erreursBouteille.type_id" label="Type" />

                    <Select v-model="formBouteille.pays_id" :options="appStore.listePays"
                        v-bind:erreur="appStore.erreursBouteille.pays_id" label="Pays" />
                </template>

                <!-- <Textarea v-bind:erreur="appStore.erreursBouteille.commentaire" v-model="formBouteille.commentaire"
                    label="Commentaire" name="commentaire" />

                <Select v-model="formBouteille.notes" name="notes" :options="tableauNotes"
                    v-bind:erreur="appStore.erreursBouteille.notes" label="Notes" /> -->


                <Input v-bind:erreur="appStore.erreursBouteille.quantite" v-model="formBouteille.quantite" label="Quantité"
                    name="quantite" type="number" min="1" />


                <Input v-bind:erreur="appStore.erreursBouteille.mellisme" v-model="formBouteille.mellisme" label="Méllisme"
                    name="mellisme" type="number" />

                <Input v-bind:erreur="appStore.erreursBouteille.date_achat" v-model="formBouteille.date_achat"
                    label="Date d'achat" name="date_achat" type="date" />

                <Input v-bind:erreur="appStore.erreursBouteille.garder_jusqu_a" v-model="formBouteille.garder_jusqu_a"
                    label="Garder jusqu'à" name="garder_jusqu_a" type="date" />

                <Input v-bind:erreur="appStore.erreursBouteille.prix_paye" v-model="formBouteille.prix_paye"
                    label="Prix d'achat" name="prix_paye" type="number" />

                <div class="flex gap-4 justify-between">
                    <Button texteBouton="Sauvegarder" />
                    <SecButton texteBouton="Annuler" @click="$emit('cacherFormBouteille')"
                        class="bg-gray-400 text-gray-900" />
                </div>

            </form>
        </div>
    </div>
</template>