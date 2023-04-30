<script setup>
import { ref, onMounted } from 'vue';
import Button from './Button.vue';
import SecButton from './SecButton.vue';
import GererCellier from '../components/GererCellier.vue';
import GererBouteille from '../components/GererBouteille.vue';
import Bouteille from '../components/Bouteille.vue';
import { useAppStore } from '../stores/app'

const appStore = useAppStore()

onMounted(async () => {
    await appStore.getCelliers()
    countCellier = appStore.celliers.length
    if (countCellier > 0) {
        form = appStore.celliers[0]
        form.nomEnCours = form.nom
    }
    await appStore.getBouteillesCellier(form.id)
})

let form = ref({
    nom: null,
    id: null
})

let formBouteille = ref({
    nom: null,
    format: null,
    bouteille_id: null,
    cellier_id: null,
    date_achat: null,
    garder_jusqu_a: null,
    notes: null,
    commentaire: null,
    prix_paye: null,
    quantite: null,
    mellisme: null,
});

const supprimerCellierForm = ref(false)
let countCellier = ref(0)

</script>

<template>
    <!-- Aucun cellier -->
    <div v-if="countCellier == 0 && !appStore.afficherForm"
        class="flex min-h-full flex-1 flex-col justify-center px-6 py-12  lg:px-8">
        Vous n'avez aucun cellier. Créer un pour gérer vos bouteilles de vin.
        <Button texte-bouton="Créer cellier" class="mt-10" @click="appStore.togglerFormCellier('nouveau')" />
    </div>
    <GererCellier v-if="appStore.afficherForm" :form="form" @cacherForm="appStore.togglerFormCellier()" />

    <!--  -->
    <div v-if="countCellier > 1" class="flex gap-10 bg-gray-100 overflow-x-auto text-gray-600 p-5 snap-x ">

        <div v-for="(cellier) in appStore.celliers"
            class="cursor-pointer flex-none bg-white rounded  w-300 shadow-md p-2 snap-center"
            :class="{ 'bg-rose-100 text-gray-600': form.id == cellier.id }"
            @click="appStore.getBouteillesCellier(cellier.id), form.id = cellier.id, form.nomEnCours = cellier.nom">
            <span>{{ cellier.nom }}</span>
            <span class="block text-sm text-gray-500">{{ cellier.contenirs_count }}</span>
        </div>
    </div>

    <div class="grid text-gray-600 p-5 gap-10">

        <form v-if="supprimerCellierForm" @submit.prevent="appStore.gererCellier(form, 'delete')" class="space-y-6">
            <div>Êtes-vous sur de supprimer <b class="block">{{ form.nom }}</b></div>
            <div class="flex gap-4 justify-between">
                <Button texteBouton="Oui supprimer" />
                <SecButton texteBouton="Annuler" @click="supprimerCellierForm = !supprimerCellierForm" />
            </div>
        </form>

        <div>
            <div class="text-2xl font-title font-semibold text-rose-800">
                {{ form?.nomEnCours }}
            </div>

            <div v-if="countCellier >= 1 && !appStore.afficherForm && !supprimerCellierForm" class="flex justify-between">
                <label @click="supprimerCellierForm = !supprimerCellierForm" class="cursor-pointer">supprimer</label>
                <label @click="appStore.togglerFormCellier(), form.nom = form.nomEnCours"
                    class="cursor-pointer">modifier</label>
                <label @click="appStore.togglerFormCellier('nouveau'), form.nom = ''" class="cursor-pointer">ajouter
                    cellier</label>
            </div>
        </div>

        <GererBouteille v-if="appStore.afficherFormBouteille" :erreur="authStore?.erreursBouteille" :cellier="form"
            :formBouteille="formBouteille" />

        <div v-if="countCellier >= 1 && !appStore.mesBouteilleCellier.length">
            <span class="">Aucune bouteille dans <em class="font-semibold">{{ form?.nomEnCours }}</em> .</span>
        </div>

        <Bouteille v-else v-for="(bouteille) in appStore.mesBouteilleCellier" :bouteille="bouteille" />


        </div>

    <header class="fixed bottom-0 bg-gray-100 w-full p-1">
        <div>gérer les bouteilles de: {{ form?.nomEnCours }}</div>
        <nav class="flex justify-around gap-3 mt-2">
            <label class="cursor-pointer border-b-rose-300 bg-purple-400 p-1"
                @click="appStore.togglerFormBouteille(), formBouteille.cellier_id = form.id">nouvelle</label>
            <label class="cursor-pointer border-b-rose-300 bg-purple-400 p-1">trouver</label>
            <label class="cursor-pointer border-b-rose-300 bg-purple-400 p-1">trier</label>
        </nav>
    </header>
</template>