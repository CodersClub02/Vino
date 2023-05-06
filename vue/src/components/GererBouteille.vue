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
import Textarea from './Textarea.vue';

const appStore = useAppStore()

onMounted(async () => {
    await appStore.getListeType();
    await appStore.getListePays();
})
const props = defineProps({

    cellier: {
        type: Object
    }

})

const afficherSuggestionsBouteilles = ref(false)
const tableauNotes = [{ id: 1, nom: '1 étoile' }, { id: 2, nom: '2 étoiles' }, { id: 3, nom: '3 étoiles' }, { id: 4, nom: '4 étoiles' }, { id: 5, nom: '5 étoiles' }]
</script>

<template>
    <div class="mx-auto  w-full max-w-lg bg-white flex gap-10 flex-col justify-center p-6">

        <h2 class="sm:mx-auto sm:w-full sm:max-w-sm text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
            <template v-if="appStore.bouteilleSelectione.id">Modifier bouteille</template>
            <template v-else>Ajouter bouteille à {{ appStore.cellierSelectione.nom }}</template>
        </h2>


        <form
            @submit.prevent="(appStore.bouteilleSelectione.id ? appStore.modifierBouteille(appStore.bouteilleSelectione) : appStore.ajouterBouteille(appStore.bouteilleSelectione))"
            class="flex gap-16 flex-col mx-auto w-full ">

            <template v-if="!appStore.bouteilleSelectione.id">
                <div>
                    <div class="flex items-center justify-between">
                        <label class="text-sm leading-6 text-gray-900 font-semibold">Source bouteille</label>
                    </div>

                    <div
                        class="mt-2 flex gap-6 w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6">
                        <label class="flex gap-2 text-sm leading-6 text-gray-900 ">
                            <input type="radio" class="form-radio accent-rose-600" name="source" value="saq"
                                v-model="appStore.bouteilleSelectione.source" checked>
                            la SAQ
                        </label>
                        <label class="flex gap-2 text-sm leading-6 text-gray-900 ">
                            <input type="radio" class="form-radio accent-rose-600" name="source" value="autre"
                                v-model="appStore.bouteilleSelectione.source">
                            Autre
                        </label>
                    </div>
                </div>

                <Input list="suggestions" v-if="(appStore.bouteilleSelectione.source || 'saq') == 'saq'"
                    v-bind:erreur="appStore.erreursBouteille.nom" v-model="appStore.bouteilleSelectione.nom"
                    label="Code saq ou nom bouteille" type="text" autocomplete="off"
                    @input="appStore.listeSuggestionsBouteilles($event.target.value), afficherSuggestionsBouteilles = true">
                <template v-slot:liste>

                    <datalist id="suggestions">
                        <option v-for="bouteille in appStore.suggestionsBouteilles">
                            {{ bouteille.nom }}
                        </option>
                    </datalist>

                </template>

                </Input>
                <template v-if="appStore.bouteilleSelectione.source == 'autre'">

                <Input v-bind:erreur="appStore.erreursBouteille.nom" v-model="appStore.bouteilleSelectione.nom"
                        label="Nom de bouteille" name="nom" type="text" />


                    <Input v-bind:erreur="appStore.erreursBouteille.millesime" v-model="appStore.bouteilleSelectione.millesime" label="Millésime" name="millesime" type="number" />
                
                    <Input v-bind:erreur="appStore.erreursBouteille.format" v-model="appStore.bouteilleSelectione.format"
                        label="Format" name="format" type="text" />

                    <!-- <Input v-bind:erreur="appStore.erreursBouteille.image" v-model="appStore.bouteilleSelectione.image" label="Image" name="image" type="file" accept="image/png, image/jpeg" /> -->

                    <Select v-model="appStore.bouteilleSelectione.type_id" :options="appStore.listeType"
                        v-bind:erreur="appStore.erreursBouteille.type_id" label="Type" />

                    <Select v-model="appStore.bouteilleSelectione.pays_id" :options="appStore.listePays"
                        v-bind:erreur="appStore.erreursBouteille.pays_id" label="Pays" />
                </template>
            </template>

            <template v-if="appStore.bouteilleSelectione.id">

                <Select v-if="appStore.celliers.length > 1" v-model="appStore.bouteilleSelectione.cellier_id"
                    :options="appStore.celliers" v-bind:erreur="appStore.erreursBouteille.cellier_id" label="Cellier" />


                <Select v-model="appStore.bouteilleSelectione.notes" name="notes" :options="tableauNotes"
                    v-bind:erreur="appStore.erreursBouteille.notes" label="Notes" />

                <Textarea v-bind:erreur="appStore.erreursBouteille.commentaire"
                    v-model="appStore.bouteilleSelectione.commentaire" label="Commentaire" name="commentaire" />
            </template>

            <Input v-bind:erreur="appStore.erreursBouteille.quantite" v-model="appStore.bouteilleSelectione.quantite"
                label="Quantité" name="quantite" type="number" min="1" />


            <Input v-bind:erreur="appStore.erreursBouteille.date_achat" v-model="appStore.bouteilleSelectione.date_achat"
                label="Date d'achat" name="date_achat" type="date" />

            <Input v-bind:erreur="appStore.erreursBouteille.garder_jusqu_a"
                v-model="appStore.bouteilleSelectione.garder_jusqu_a" label="Garder jusqu'à" name="garder_jusqu_a"
                type="number"/>

            <Input v-bind:erreur="appStore.erreursBouteille.prix_paye" v-model="appStore.bouteilleSelectione.prix_paye"
                label="Prix d'achat" name="prix_paye" type="number" />

            <div class="flex gap-4 justify-between">
                <Button texteBouton="Sauvegarder" />
                <SecButton texteBouton="Annuler" @click="$emit('cacherFormBouteille')" class="bg-gray-400 text-gray-900" />
            </div>

        </form>

    </div>
</template>