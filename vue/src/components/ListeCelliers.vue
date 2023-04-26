<script setup>
import { ref, onMounted } from 'vue';
import Button from './Button.vue';
import AjouterCellier from '../components/AjouterCellier.vue';
import { useAppStore } from '../stores/app'

const appStore = useAppStore()

onMounted(async ()=> {
    await appStore.getCelliers()
})
let ajouterCellier = ref(false)
</script>
<template>
    <div class="p-5 flex justify-center" v-if="!ajouterCellier">
        <Button texteBouton="Ajouter Cellier" @click="ajouterCellier = !ajouterCellier" />
    </div>
    <AjouterCellier v-if="ajouterCellier" />

    <div class="bg-gray-100  text-gray-600  p-5">
        <div class="grid lg:grid-cols-4 md:grid-cols-3 gap-10">
            <div v-for="(cellier) in appStore.celliers" class=" bg-white rounded overflow-hidden shadow-md">
                <img src="/cellier.jpg" class=" w-full h-45 sm:h-50 object-cover" alt="cellier">
                <div class="m-4">
                    <span class="text-lg font-semibold  font-body">{{ cellier.nom }}</span>
                    <span class="block text-sm text-gray-500 font-body ">nombre de bouteilles</span>
                </div>
            </div>
        </div>
    </div>
</template>