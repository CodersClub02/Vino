<script setup>
import { ref, onMounted } from 'vue';
import { useAdminStore } from '../stores/admin'
import Chargement from './Chargement.vue';


const adminStore = useAdminStore()
onMounted(async () => {
    await adminStore.getMembres(1)
})
</script>

<template>

    <Chargement :estActive="adminStore.chargement" />

    <article v-if="!adminStore.listeMembres" class="flex items-center flex-col gap-6 p-6">
        <h2 class="text-orange-400 text-xl">Aucun membre</h2>
        <div>Bonne chance</div>
    </article>
    <article v-else class="grid cols-2 gap-6 lg:gap-10 lg:grid-cols-3 md:gap-10 md:grid-cols-2">

        <header class="text-rose-400 col-span-full">
        {{ adminStore.listeMembres.total }} membre(s) (30 par page)
        </header>

        <article v-for="membre in adminStore.listeMembres" class="flex flex-col bg-white shadow-md p-3 rounded">
            <h2>{{ membre.name }} | {{ membre.email }}</h2>
            <div>Celliers: {{ membre.celliers_count }} | Bouteilles: {{ membre.contenirs_count }}</div>
            <div v-if="membre.actif" class='text-rose-600'>
                <label class="cursor-pointer border border-rose-500 max-w-max p-1 px-2 block rounded mt-4"
                    @click="adminStore.modifierStatutMembre(membre)">suspendre
                </label>
            </div>
            <div v-else class=" text-green-600">
                <label class="cursor-pointer border border-green-600 text-green-600 bg-green-100 max-w-max p-1 px-2 block rounded mt-4"
                    @click="adminStore.modifierStatutMembre(membre)">activer</label>
            </div>
        </article>

        <div class="fixed bottom-0 left-0 w-full p-5 bg-rose-800/90 flex justify-center">
            <div class="flex justify-center items-center gap-10 border-2 border-white/60 rounded-lg">
                <div @click="adminStore.getMembres(adminStore.listeMembres.page_precedente)">
                    <img src="/icones/gauche.svg" class="w-10 h-10">
                </div>
                <span class="flex gap-2 text-white/60">
                    <span class="font-semibold text-white/90">
                        {{adminStore.listeMembres.page_en_cours}}
                    </span>
                    / 
                    <span>
                       {{ adminStore.listeMembres.derniere_page}}
                    </span>
                </span>
                <div @click="adminStore.getMembres(adminStore.listeMembres.page_suivante)">
                    <img src="/icones/droite.svg" class="w-10 h-10">
                </div>
            </div>
        </div>

    </article>
</template>