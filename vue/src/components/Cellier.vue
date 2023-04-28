<script setup>
import { ref, onMounted } from 'vue';
import Button from './Button.vue';
import GererCellier from '../components/GererCellier.vue';
import GererBouteille from '../components/GererBouteille.vue';
import { useAppStore } from '../stores/app'

const appStore = useAppStore()

onMounted(async () => {
    await appStore.getCelliers()
    form = appStore.celliers[0]
    countCellier = appStore.celliers.length
    if (countCellier === 0) appStore.togglerFormCellier()
    await appStore.getBouteillesCellier(form.id)
})

let form = ref({
    nom: "",
    id: null
})

const supprimerCellierForm = ref(false)
let countCellier = ref(0)

</script>
<template>
    <div class="p-5 flex justify-center" v-if="!appStore.afficherForm">
        <Button texteBouton="Ajouter Cellier" @click="appStore.togglerFormCellier()" />
    </div>

    <GererCellier v-if="appStore.afficherForm" :form="form" @cacherForm="appStore.togglerFormCellier()" />

    <div v-if="countCellier > 1"
        class="transition duration-150 hover:ease-in ease-out bg-gray-100 overflow-x-auto text-gray-600 p-5 flex snap-x gap-10">

        <!--  -->
        <div v-for="(cellier) in appStore.celliers" :class="{ 'bg-rose-100 text-gray-600': form.id == cellier.id }"
            class="flex-none bg-white rounded  w-300 shadow-md p-2 snap-center"
            @click="appStore.getBouteillesCellier(cellier.id), form.id = cellier.id, form.nom = cellier.nom">
            <span class="font-body ">{{ cellier.nom }}</span>
            <span class="block text-sm text-gray-500">{{ cellier.contenirs_count }}</span>
        </div>
    </div>

    <div class="grid text-gray-600 p-5 gap-10">

        <form v-if="supprimerCellierForm" @submit.prevent="appStore.gererCellier(form, 'delete')" class="space-y-6">
            <div>êtes vous sur de supprimer <b class="block">{{ form.nom }}</b></div>
            <div class="flex gap-4 justify-between">
                <Button texteBouton="Oui supprimer" />
                <SecButton texteBouton="Annuler" @click="supprimerCellierForm = !supprimerCellierForm" />
            </div>
        </form>

        <div>
            <div class="text-2xl font-title font-semibold text-rose-800">
                {{ form.nom }}
            </div>

            <div class="flex justify-between">
                <label @click="supprimerCellierForm = !supprimerCellierForm">supprimer</label>
                <label @click="appStore.togglerFormCellier()">modifier</label>
                <label @click="appStore.togglerFormCellier('nouveau')">nouveau cellier</label>
            </div>
        </div>

        <GererBouteille v-if="appStore.afficherFormBouteille" :erreur="authStore?.erreursBouteille"
            :cellierId="form.cellier_id" />

        <div v-for="(bouteille) in appStore.mesBouteilleCellier"
            class=" bg-white rounded overflow-hidden shadow-md p-2 snap-center">
            <span class="text-lg font-semibold">{{ bouteille.nom }}</span>
            <span class="block text-sm text-gray-500">{{ bouteille.nombre_bouteille }}</span>
        </div>
    </div>

    <label @click="appStore.togglerFormBouteille()"
        class=" m-2 rounded  cursor-pointer font-body text-white bg-rose-800 p-3">ajouter
        bouteille</label>
</template>