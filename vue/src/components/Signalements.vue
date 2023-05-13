<script setup>
import { onMounted } from 'vue';

import GererSignalement from './GererSignalement.vue';
import { useAdminStore } from '../stores/admin'


const adminStore = useAdminStore()
onMounted(async () => {
    await adminStore.getSignalements()
})
</script>

<template>
<article v-if="!adminStore.listeSignalements" class="flex items-center flex-col gap-6 p-6">
    <h2 class="text-orange-400 text-xl">Aucun signalement</h2>
    <div>tout est bon pour l'instant</div>
</article>
<article v-else-if="!adminStore.bouteilleACorriger?.id" class="grid gap-6 lg:gap-10 lg:grid-cols-3 md:gap-10 md:grid-cols-2">

        <div v-for="signalement in adminStore.listeSignalements" class="bg-slate-200">

            <div class="flex p-5">

                <picture class="h-36 w-20 flex-none relative overflow-hidden">
                    <img :src="signalement.url_image_saq || '/bouteille-non-liste.jpg'" class="image" />
                </picture>

                <!-- bouteille -->
                <div class="flex gap-2 flex-col grow">
                    <span class="font-bold">{{ signalement.nom }} <span class="text-orange-500">{{ signalement.prix_saq }}</span></span>
                    <span>{{ signalement.description_saq }} | {{ signalement.format }}</span>
                    <span class="flex flex-wrap gap-1">
                        {{ signalement.code_saq }} <a :href="signalement.url_saq" target="_blank"
                        class="flex gap-1  text-rose-900 items-center cursor-pointer">voir sur saq.com</a>
                    </span>
                </div>
            </div>

            <div class="flex flex-col bg-orange-200 p-2">
                    <span>{{ signalement.name }}</span>
                    <span>{{ signalement.message }}</span>
                    
                    <div v-if="signalement.resolue" class="flex justify-between bg-slate-400 p-2 text-green-500">
                        <span>résolu</span>
                        <span>{{ signalement.date_resolution }}</span>
                    </div>
                    <div v-else class="flex justify-end bg-slate-400 p-2">
                        <label @click="adminStore.togglerFormSignalement({bouteille_id: signalement.bouteille_id, name: signalement.name, anomalie_id: signalement.anomalie_id, message: signalement.message})" class="cursor-pointer">Résoudre</label>
                    </div>
                </div>
        </div>
</article>

<GererSignalement v-else />
</template>