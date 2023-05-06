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
    <article class="relative flex flex-col gap-5 p-3 shadow-md bg-white max-w-xs mx-auto w-full">

        <span class="absolute left-3 top-0 w-12 h-4 flex justify-center items-center rounded-full bg-slate-500/20">. . .</span>
        <div class="hidden gap-8 justify-end">
                <font-awesome-icon icon="fa-solid fa-trash" class="text-gray-300 cursor-pointer text-2xl"
                    @click="appStore.togglerFormSupprimerBouteille(bouteille)" />

                <font-awesome-icon icon="fa-solid fa-pen-to-square" class="text-gray-300 cursor-pointer text-2xl"
                    @click="appStore.togglerFormBouteille(bouteille)" />

                <a class="" :href="bouteille.url_saq">
                    <font-awesome-icon icon="fa-solid fa-eye" class="text-gray-300 cursor-pointer text-2xl" />
                </a>
        </div>

        <div class="flex gap-4 justify-start items-start w-full">
            <picture class="h-36 w-20 flex-none relative overflow-hidden">
                <img :src="bouteille.url_image_saq||'/bouteille-non-liste.jpg'" class="" style="position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    height: 90%;
    width: initial;
    max-width: min-content;
    z-index: 0;" />
            </picture>
        <section class="flex flex-col gap-2 max-w-fit">
            <header class="flex flex-col gap-0 items-baseline w-full">
                <h1 class="text-md font-semibold w-full line-clamp-2 h-12">
                    {{ bouteille.nom }}
                </h1>
                <h2 class="md:truncate lg:truncate xl:truncate text-xs lowercase text-gray-400">
                    {{ bouteille.type.nom }}
                    |
                    {{ bouteille.format }}
                    |
                    {{ bouteille.pays.nom }}
                </h2>
            </header>

            <div class="w-full flex gap-2 justify-center items-center p-1">
                <span v-for="i in 5" class="flex flex-col justify-center items-center rounded-3xl cursor-pointer w-5 h-5"
                    @click="bouteille.notes = i">
                    <img :src="'/etoile' + (i <= bouteille.notes ? '-solide' : '') + '.png'">
                </span>
            </div>
            <div class="w-full flex gap-2 justify-center items-center py-1 px-1">
                <span
                    class="flex flex-col gap-3 justify-center items-center aspect-square text-2xl text-gray-400 shadow-md rounded-3xl border cursor-pointer w-7 h-7"
                    @click="(bouteille.quantite<= 0 ? 0 : --bouteille.quantite )">-</span>
                <div class="flex text-xl px-1 justify-center items-center">{{ bouteille.quantite }}</div>
                <span
                    class="flex flex-col gap-3 justify-center items-center aspect-square text-2xl text-gray-400 shadow-md border rounded-3xl cursor-pointer w-7 h-7"
                    @click="++bouteille.quantite">+</span>
            </div>

        </section>
        </div>

    </article>
</template>