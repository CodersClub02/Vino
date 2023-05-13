<script setup>
import { ref, onMounted } from 'vue';
import { useAdminStore } from '../stores/admin'


const adminStore = useAdminStore()
onMounted(async () => {
    await adminStore.getMembres()

})
</script>

<template>
    <article v-if="!adminStore.listeMembres" class="flex items-center flex-col gap-6 p-6">
        <h2 class="text-orange-400 text-xl">Aucun membre</h2>
        <div>Bonne chance</div>
    </article>
    <article v-else class="grid cols-2 gap-6 lg:gap-10 lg:grid-cols-3 md:gap-10 md:grid-cols-2">

        <article v-for="membre in adminStore.listeMembres" class="flex flex-col bg-orange-400/20 p-3">
            <h2>{{ membre.name }} | {{ membre.email }}</h2>
            <div>Celliers: {{ membre.celliers_count }} | Bouteilles: {{ membre.contenirs_count }}</div>
            <div v-if="membre.actif">
                <label class="cursor-pointer" @click="adminStore.modifierStatutMembre(membre)">suspendre membre</label>
            </div>
            <div v-else class="flex justify-end text-red-600">
                <label class="cursor-pointer" @click="adminStore.modifierStatutMembre(membre)">activer membre</label>
            </div>
        </article>

    </article>
</template>