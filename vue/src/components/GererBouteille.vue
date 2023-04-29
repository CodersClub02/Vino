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

const props = defineProps({

    cellier: {
        type: Object
    },

    formBouteille: {
        type: Object
    }

})

const afficherSuggestionsBouteilles = ref(false)

</script>

<template>
    <div class="mx-auto max-w-7xl sm:px-6 bg-white flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Ajouter bouteille a
                {{ cellier.nomEnCours }}
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form @submit.prevent="appStore.ajouterBouteille(formBouteille)" class="space-y-6">

                <Input v-bind:erreur="appStore.erreursBouteille.bouteille_id" v-model="formBouteille.nom"
                    label="Code saq ou nom bouteille" type="text" autocomplete="off"
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

                <Textarea v-bind:erreur="appStore.erreursBouteille.commentaire" v-model="formBouteille.commentaire"
                    label="Commentaire" name="commentaire" />

                <Input v-bind:erreur="appStore.erreursBouteille.quantite" v-model="formBouteille.notes" label="Notes"
                    name="notes" type="number" min="1" />

                <Input v-bind:erreur="appStore.erreursBouteille.quantite" v-model="formBouteille.quantite" label="Quantité"
                    name="quantite" type="number" min="1" />


                <Input v-bind:erreur="appStore.erreursBouteille.mellisme" v-model="formBouteille.mellisme" label="Méllisme"
                    name="mellisme" type="number" />

                <Input v-bind:erreur="appStore.erreursBouteille.date_achat" v-model="formBouteille.date_achat"
                    label="Date d'achat" name="date_achat" type="date" />

                <Input v-bind:erreur="appStore.erreursBouteille.garder_jusqu_a" v-model="formBouteille.garder_jusqu_a"
                    label="Garder jusqu'à" name="garder_jusqu_a" type="date" />

                <Input v-bind:erreur="appStore.erreursBouteille.prix_paye" v-model="formBouteille.prix_paye" label="Prix"
                    name="prix_paye" type="number" />

                <div class="flex gap-4 justify-between">
                    <Button texteBouton="Sauvegarder" />
                    <Button texteBouton="Annuler" @click="$emit('cacherForm')" class="bg-gray-400 text-gray-900" />
                </div>

            </form>
        </div>
    </div>
</template>