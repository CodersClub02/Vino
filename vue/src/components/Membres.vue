<script setup>
import { ref, onMounted } from 'vue';
import { useAdminStore } from '../stores/admin'


const adminStore = useAdminStore()
onMounted(async () => {
    await adminStore.getMembres(1)
})
</script>

<template>
    <article v-if="!adminStore.listeMembres" class="flex items-center flex-col gap-6 p-6">
        <h2 class="text-orange-400 text-xl">Aucun membre</h2>
        <div>Bonne chance</div>
    </article>
    <article v-else class="grid cols-2 gap-6 lg:gap-10 lg:grid-cols-3 md:gap-10 md:grid-cols-2">

        <article v-for="membre in adminStore.listeMembres" class="flex flex-col bg-gray-200 p-3 rounded">
            <h2>{{ membre.name }} | {{ membre.email }}</h2>
            <div>Celliers: {{ membre.celliers_count }} | Bouteilles: {{ membre.contenirs_count }}</div>
            <div v-if="membre.actif" class='text-rose-600'>
                <label class="cursor-pointer border border-rose-500 max-w-max p-1 px-2 block rounded mt-4"
                    @click="adminStore.modifierStatutMembre(membre)">suspendre
                </label>
            </div>
            <div v-else class=" text-green-600">
                <label class="cursor-pointer border border-green-600 max-w-max p-1 px-2 block rounded mt-4"
                    @click="adminStore.modifierStatutMembre(membre)">activer</label>
            </div>
        </article>

        <div class="fixed bottom-0 left-0 w-full p-5 flex justify-center gap-10 bg-gray-800">
            <label @click="adminStore.getMembres(1)" class="flex justify-center items-center w-10 h-10 bg-red-400 rounded-full">1</label>
            <label @click="adminStore.getMembres(adminStore.listeMembres.page_precedente)" class="flex justify-center items-center w-10 h-10 bg-red-400 rounded-full">{{ adminStore.listeMembres.page_precedente }}</label>
            <label class="flex justify-center items-center w-10 h-10 bg-red-400 rounded-full text-white">{{ adminStore.listeMembres.page_en_cours }}</label>
            <label @click="adminStore.getMembres(adminStore.listeMembres.page_suivante)" class="flex justify-center items-center w-10 h-10 bg-red-400 rounded-full">{{ adminStore.listeMembres.page_suivante }}</label>
            <label @click="adminStore.getMembres(adminStore.listeMembres.derniere_page)" class="flex justify-center items-center w-10 h-10 bg-red-400 rounded-full">{{ adminStore.listeMembres.derniere_page }}</label>
        </div>

    </article>
</template>