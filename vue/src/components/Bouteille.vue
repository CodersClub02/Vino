<script setup>
import { watch } from "vue";
import { useAppStore } from '../stores/app'
const appStore = useAppStore()

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
    <article class="relative flex flex-col gap-5 p-3 shadow-md bg-white max-w-xs mx-auto">

        <div class="flex gap-8 justify-end flex-col absolute right-3 top-5">
                <font-awesome-icon icon="fa-solid fa-trash" class="text-gray-300 cursor-pointer text-2xl"
                    @click="appStore.togglerFormSupprimerBouteille(bouteille)" />

                <font-awesome-icon icon="fa-solid fa-pen-to-square" class="text-gray-300 cursor-pointer text-2xl"
                    @click="appStore.togglerFormBouteille(bouteille)" />

                <a class="" :href="bouteille.url_saq">
                    <font-awesome-icon icon="fa-solid fa-eye" class="text-gray-300 cursor-pointer text-2xl" />
                </a>
        </div>

        <img :src="bouteille.url_image_saq||'/bouteille-non-liste.jpg'" class="h-48 m-auto" />

        <section class="flex flex-col gap-2">
            <header class="flex flex-col gap-0 items-baseline">
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
                <span v-for="i in 5" class="flex flex-col justify-center items-center rounded-3xl cursor-pointer w-7 h-10"
                    @click="bouteille.notes = i">
                    <img :src="'/etoile' + (i <= bouteille.notes ? '-solide' : '') + '.png'">
                </span>
            </div>
            <div class="w-full flex gap-1 justify-center items-center py-3 px-10 border rounded-sm">
                <span
                    class="flex flex-col gap-3 justify-center items-center  aspect-square text-2xl text-gray-400  shadow-md rounded-3xl border cursor-pointer w-10 h-10"
                    @click="--bouteille.quantite">-</span>
                <div class="flex text-4xl px-10 grow justify-center items-center">{{ bouteille.quantite }}</div>
                <span
                    class="flex flex-col gap-3 justify-center items-center  aspect-square text-2xl text-gray-400 shadow-md border rounded-3xl cursor-pointer w-10 h-10"
                    @click="++bouteille.quantite">+</span>
            </div>

        </section>
    </article>
</template>