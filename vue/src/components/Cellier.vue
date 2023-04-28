<script setup>
import { ref, onMounted } from 'vue';
import Button from './Button.vue';
import GererCellier from '../components/GererCellier.vue';
import GererBouteille from '../components/GererBouteille.vue';
import { useAppStore } from '../stores/app'

const appStore = useAppStore()

onMounted(async ()=> {
    await appStore.getCelliers()
    form.cellier_id = appStore.celliers[0].id
    await appStore.getBouteillesCellier(form.cellier_id)
    console.log(form.cellier_id);
})
let form = ref({
    nom: "",
    cellier_id: null
})

</script>
<template>
    <div class="p-5 flex justify-center" v-if="!appStore.afficherForm">
        <Button texteBouton="Ajouter Cellier" @click="appStore.togglerFormCellier()" />
    </div>
    
    <GererCellier v-if="appStore.afficherForm" :form="form" @cacherForm="appStore.togglerFormCellier()" />

    <div class="bg-gray-100 text-gray-600 p-5 flex snap-x gap-10">
            <div v-for="(cellier) in appStore.celliers" class=" bg-white rounded overflow-hidden shadow-md p-2 snap-center" @click="appStore.getBouteillesCellier(cellier.id), form.cellier_id=cellier.id">
                    <span class="text-lg font-semibold">{{ cellier.nom }}</span>
                    <span class="block text-sm text-gray-500">{{ cellier.nombre_bouteille }}</span>
        </div>
    </div>

    <div class="grid text-gray-600 p-5 gap-10">

        <div class="flex justify-between">

            <label @click="appStore.togglerFormBouteille()">ajouter bouteille</label>
            <label>modifier cellier</label>

        </div>
        
        <GererBouteille v-if="appStore.afficherFormBouteille" :erreur="authStore?.erreursBouteille" :cellierId="form.cellier_id" />

        <div v-for="(bouteille) in appStore.mesBouteilleCellier" class=" bg-white rounded overflow-hidden shadow-md p-2 snap-center">
            <span class="text-lg font-semibold">{{ bouteille.nom }}</span>
            <span class="block text-sm text-gray-500">{{ bouteille.nombre_bouteille }}</span>
        </div>
    </div>

</template>