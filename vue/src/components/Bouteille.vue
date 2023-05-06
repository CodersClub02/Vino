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
    <article class="relative isolate flex flex-col gap-5 p-3 shadow-md bg-white max-w-xs mx-auto w-full">

        <span class="absolute z-10 left-3 top-2 w-12 h-4" @click="appStore.togglerBouteilleAgerer(bouteille.id)">
            <img src="/icones/plus.svg">
        </span>
        <div class="absolute inset-0 z-10 bg-white flex gap-2 flex-col justify-center items-center" :class="appStore.bouteilleAgerer == bouteille.id ? '' : 'opacity-0 pointer-events-none'">

            <img src="/icones/fermer.svg" @click="appStore.togglerBouteilleAgerer(-1)" class="absolute top-2 right-2 aspect-square h-4" />

            <label @click="appStore.togglerFormSupprimerBouteille(bouteille)" class="flex gap-4 items-center w-36">
                <img src="/icones/supprimer-bouteille.svg" class="h-5" />
                supprimer
            </label>
            
            <label @click="appStore.togglerFormBouteille(bouteille)" class="flex gap-4 items-center w-36">
                <img src="/icones/modifier-bouteille.svg" class="h-5" />
                modifier
            </label>

            <a :href="bouteille.url_saq" class="flex gap-4 items-center w-36">
                <img src="/icones/saq.svg" class="h-5" />
                voir sur saq
            </a>
                
        </div>

        <div class="flex gap-4 justify-start items-start w-full">
            <picture class="h-36 w-20 flex-none relative overflow-hidden">
                <img :src="bouteille.url_image_saq||'/bouteille-non-liste.jpg'" class="image" />
            </picture>
        <section class="flex flex-col gap-2 max-w-fit">
            <header class="flex flex-col gap-0 items-baseline w-full">
                <h1 class="text-md w-full line-clamp-2 h-12" style="color: #ad5f00;">
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
                    <img :src="'/icones/etoile' + (i <= bouteille.notes ? '-solide' : '') + '.png'">
                </span>
            </div>
            <div class="w-full flex gap-2 justify-center items-center py-1 px-1">
                <span
                    class="flex flex-col gap-3 justify-center items-center aspect-square text-2xl text-gray-400 shadow-md rounded-3xl border cursor-pointer w-7 h-7"
                    @click="(bouteille.quantite > 1 && --bouteille.quantite ), (bouteille.quantite == 1 && appStore.togglerFormSupprimerBouteille(bouteille))">-</span>
                <div class="flex text-xl px-1 justify-center items-center">{{ bouteille.quantite }}</div>
                <span
                    class="flex flex-col gap-3 justify-center items-center aspect-square text-2xl text-gray-400 shadow-md border rounded-3xl cursor-pointer w-7 h-7"
                    @click="++bouteille.quantite">+</span>
            </div>

        </section>
        </div>

    </article>
</template>

<style scoped>
.bouteille{
    background-image: linear-gradient(265deg, rgb(246 148 148 / 8%) 0%, rgb(255 255 255) 100%);
}
.image{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    height: 90%;
    width: initial;
    max-width: min-content;
    z-index: 0;
}
</style>