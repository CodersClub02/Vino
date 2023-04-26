<script setup>
import { ref } from 'vue';
const celliers = ref([
    { nom: 'cellier 1', id: 1 },
    { nom: 'cellier 2', id: 2 },
    { nom: 'cellier 3', id: 3 },
    { nom: 'cellier 4', id: 4 },
])
</script>
<template>
    <div class="bg-gray-100  text-gray-600  p-5">

        <div class="grid lg:grid-cols-4 md:grid-cols-3 gap-10">
            <div v-for="(cellier) in celliers" class=" bg-white rounded overflow-hidden shadow-md">
                <img src="cellier.jpg" class=" w-full h-45 sm:h-50 object-cover" alt="cellier">
                <div class="m-4">
                    <span class="text-lg font-semibold  font-body">{{ cellier.nom }}</span>
                    <span class="block text-sm text-gray-500 font-body ">nombre de bouteilles</span>
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="m-5 border-2 rounded p-2 text-center font-semibold text-rose-400 border-rose-400 ">charger plus
            </div>
        </div>

    </div>
</template>