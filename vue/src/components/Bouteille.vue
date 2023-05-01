<script setup>
import { defineProps } from 'vue';

defineProps({
    bouteille: {
        type: Object,
    }
})
</script>

<template>

<article class="flex flex-col gap-2 p-3 bg-yellow-100">
    
    <a class="w-40 relative" :href="bouteille.url_saq">
        <sup class="absolute z-10 top-1 bg-white flex p-2">{{ bouteille.code_saq }}</sup>
        <img :src="bouteille.url_image_saq" class="w-full"/>
    </a>
    
    <section class="flex flex-col gap-2">
        <header class="flex flex-col gap-2 items-baseline">
            <h1 class="text-lg font-semibold">{{ bouteille.nom }}</h1>
            <h2>
                <span class="font-bold text-red-600">{{ bouteille.prix_paye }}$ {{ bouteille.prix_saq }}$</span>
                |
                {{ bouteille.type.nom }}
                |
                {{ bouteille.format }}
                |
                {{ bouteille.pays.nom }}
            </h2>
        </header>

        <div class="flex gap-5 justify-center items-center">
            <div class="flex gap-2 items-center bg-slate-400">
                <span class="flex flex-col gap-3">
                    <span class="flex justify-center items-center bg-orange-600 aspect-square w-8 text-2xl text-white cursor-pointer">+</span>
                    <span class="flex justify-center items-center bg-orange-600 aspect-square w-8 text-2xl text-white cursor-pointer">-</span>
                </span>
                <div class="flex text-4xl px-10 w-40 justify-center items-center">{{ bouteille.notes }}</div>
            </div>
            <div class="flex gap-2 items-center bg-slate-400">
                <div class="flex text-4xl px-10 w-40 justify-center items-center">{{ bouteille.quantite }}</div>
                <span class="flex flex-col gap-3">
                    <span class="flex justify-center items-center bg-orange-600 aspect-square w-8 text-2xl text-white cursor-pointer">+</span>
                    <span class="flex justify-center items-center bg-orange-600 aspect-square w-8 text-2xl text-white cursor-pointer">-</span>
                </span>
            </div>
        </div>

        <label class="cursor-pointer border-b-rose-300 bg-purple-400 p-1" @click="appStore.togglerFormBouteille(), formBouteille = bouteille">modifier</label>
        
        <div>comentaire: {{ bouteille.comentaire }}</div>
        <div>mellisme: {{ bouteille.mellisme }}</div>
        <div>date_achat: {{ bouteille.date_achat }}</div>
        <div>garder_jusqu_a: {{ bouteille.garder_jusqu_a }}</div>

    </section>
</article>
</template>