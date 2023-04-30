<script setup>
import { defineProps } from 'vue';

defineProps({
    bouteille: {
        type: Object,
    }
})
</script>

<template>

<article class="flex gap-2 p-3 bg-yellow-100">
    <a class="w-40" :href="bouteille.url_saq">
        <img :src="bouteille.url_image_saq" class="w-full"/>
        <sup>{{ bouteille.code_saq }}</sup>
    </a>
    
    <section class="flex flex-col gap-2">
        <div>
            <header class="flex gap-2 items-baseline">
                <h1 class="text-lg font-semibold">{{ bouteille.nom }}</h1>
                {{ bouteille.format }}
            </header>
            <h2>
                <span class="font-bold text-red-600">{{ bouteille.prix_saq }}$</span>
                |
                {{ bouteille.type.nom }}
                |
                {{ bouteille.pays.nom }}
            </h2>
        </div>

        <div>
            <div>date_achat: {{ bouteille.date_achat }}</div>
            <div>garder_jusqu_a: {{ bouteille.garder_jusqu_a }}</div>
            <div>notes: {{ bouteille.notes }}</div>
            <div>prix_paye: {{ bouteille.prix_paye }}</div>
            <div>quantite: {{ bouteille.quantite }}</div>
            <div>mellisme: {{ bouteille.mellisme }}</div>
            <label class="cursor-pointer border-b-rose-300 bg-purple-400 p-1" @click="appStore.togglerFormBouteille(), formBouteille = bouteille">modifier</label>
        </div>
    </section>
</article>
</template>