<script setup>
import { onMounted } from 'vue';

import GererSignalement from './GererSignalement.vue';
import Chargement from './Chargement.vue';

import { useAdminStore } from '../stores/admin'


const adminStore = useAdminStore()
onMounted(async () => {
    await adminStore.getSignalements(1)
})
</script>

<template>

<Chargement :estActive="adminStore.chargement" />

<article v-if="!adminStore.listeSignalements.length" class="flex items-center flex-col gap-6 p-6">
    <h2 class="text-orange-400 text-xl">Aucun signalement</h2>
    <div>tout est bon pour l'instant</div>
</article>
<article v-else-if="!adminStore.bouteilleACorriger?.id" class="grid gap-6 lg:gap-10 lg:grid-cols-3 md:gap-10 md:grid-cols-2">

    <header class="text-rose-400 col-span-full">
        {{ adminStore.listeSignalements.total }} signalement(s)
    </header>

        <div v-for="signalement in adminStore.listeSignalements" class="shadow-md bg-white max-w-xs m-auto">

            <div class="flex p-5 md:h-48">

                <picture class="h-36 w-20 flex-none relative overflow-hidden">
                    <img :src="signalement.url_image_saq || '/bouteille-non-liste.jpg'" class="image" />
                </picture>

                <!-- bouteille -->
                <div class="flex gap-2 flex-col grow">
                    <span class="text-md w-full md:line-clamp-2 h-10 text-rose-800 leading-5 overflow-hidden">{{ signalement.nom }} <span class="text-orange-500 ">{{ signalement.prix_saq }}</span></span>
                    <span class="text-sm">{{ signalement.description_saq }} | {{ signalement.format }}</span>
                    <span class="flex flex-wrap gap-1 text-sm">
                        {{ signalement.code_saq }} <a :href="signalement.url_saq" target="_blank"
                        class="flex gap-1  text-rose-900 items-center cursor-pointer">voir sur saq.com</a>
                    </span>
                </div>
            </div>

            <div class="flex flex-col border-t p-2 px-5 bg-slate-100/50">
                    <span class="font-semibold text-xs text-rose-600">{{ signalement.name }}</span>
                    <span class="md:h-12 lg:line-clamp-2 overflow-hidden">{{ signalement.anomalie }}</span>

                    <div class="flex justify-end p-2">
                        <label @click="adminStore.togglerFormSignalement({contenir_id: signalement.contenir_id, bouteille_id: signalement.bouteille_id, name: signalement.name, anomalie: signalement.anomalie})" class="cursor-pointer border border-green-600 text-green-600 bg-green-100 max-w-max p-1 px-2 block rounded">résoudre</label>
                    </div>
                </div>
        </div>

        <div class="fixed bottom-0 left-0 w-full p-5 bg-rose-800/90 flex justify-center">
            <div class="flex justify-center items-center gap-10 border-2 border-white/60 rounded-lg">
                <div @click="adminStore.getSignalements(adminStore.listeSignalements.page_precedente)" class="cursor-pointer">
                    <img src="/icones/gauche.svg" class="w-10 h-10">
                </div>
                <span class="flex gap-2 text-white/60">
                    <span class="font-semibold text-white/90">
                        {{adminStore.listeSignalements.page_en_cours}}
                    </span>
                    / 
                    <span>
                       {{ adminStore.listeSignalements.derniere_page}}
                    </span>
                </span>
                <div @click="adminStore.getSignalements(adminStore.listeSignalements.page_suivante)" class="cursor-pointer">
                    <img src="/icones/droite.svg" class="w-10 h-10">
                </div>
            </div>
        </div>
</article>

<GererSignalement v-else />
</template>