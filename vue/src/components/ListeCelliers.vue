<script setup>
import { ref } from 'vue';
import Button from './Button.vue';
import { useAppStore } from '../stores/app'

const appStore = useAppStore()
await appStore.getCelliers()
console.log('kkkkkkkkkkkk', appStore.celliers);
</script>
<template>
    <Button texteBouton="Ajouter Cellier" />
    <div class="bg-gray-100  text-gray-600  p-5">

        <div class="grid lg:grid-cols-4 md:grid-cols-3 gap-10">
            <div v-for="(cellier) in celliers" class=" bg-white rounded overflow-hidden shadow-md">
                <img src="/cellier.jpg" class=" w-full h-45 sm:h-50 object-cover" alt="cellier">
                <div class="m-4">
                    <span class="text-lg font-semibold  font-body">{{ cellier.nom }}</span>
                    <span class="block text-sm text-gray-500 font-body ">nombre de bouteilles</span>
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div
                class="m-5 border-2 rounded-full py-2 px-3 text-center text-sm cursor-pointer font-semibold text-rose-400 border-rose-400 lg:hover:bg-rose-400 lg:hover:text-white ">
                charger plus
            </div>
        </div>

    </div>
</template>