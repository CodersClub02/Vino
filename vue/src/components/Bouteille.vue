<script setup>
import { watch } from "vue";
import { useAppStore } from '../stores/app'
const appStore = useAppStore()

import { defineProps } from 'vue';

const props = defineProps({
    bouteille: {
        type: Object,
    }
})

watch(props.bouteille, (currentState, prevState) => {
    appStore.modifierBouteille(currentState)
}, { deep: true })


</script>

<template>

<article class="flex flex-col gap-2 p-3 shadow-md bg-white">
    
    <a class="relative w-full" :href="bouteille.url_saq">
        <img :src="bouteille.url_image_saq" class="h-48 m-auto"/>
    </a>
    
    <section class="flex flex-col gap-2">
        <header class="flex flex-col gap-2 items-baseline">
            <h1 class="w-full text-lg font-semibold md:truncate lg:truncate xl:truncate">{{ bouteille.nom }}</h1>
            <h2 class="truncate">
                <span class="font-bold text-red-600">{{ bouteille.prix_paye }}$</span>
                |
                {{ bouteille.type.nom }}
                |
                {{ bouteille.format }}
                |
                {{ bouteille.pays.nom }}
            </h2>
        </header>

        <div class="w-full flex gap-2 justify-center items-center p-3">
            <span v-for="i in 5" class="flex flex-col justify-center items-center rounded-3xl cursor-pointer w-7 h-10" @click="bouteille.notes=i">
                <img :src="'/etoile' + ( i <= bouteille.notes ? '-solide' : '' ) + '.png'">
            </span>
        </div>
        <div class="w-full flex gap-1 justify-center items-center p-3 border rounded-sm">
            <span class="flex flex-col gap-3 justify-center items-center bg-rose-600 aspect-square text-2xl text-white rounded-3xl cursor-pointer w-10 h-10" @click="--bouteille.quantite">-</span>
                <div class="flex text-4xl px-10 grow justify-center items-center">{{ bouteille.quantite }}</div>
                <span class="flex flex-col gap-3 justify-center items-center bg-rose-600 aspect-square text-2xl text-white rounded-3xl cursor-pointer w-10 h-10" @click="++bouteille.quantite">+</span>
        </div>

        <label class="cursor-pointer border-b-rose-300 bg-purple-400 p-1"
         @click="appStore.togglerFormBouteille(bouteille)">modifier</label>

    </section>
</article>
</template>
