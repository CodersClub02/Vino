<script setup>
import { onMounted } from 'vue';

import GererSignalement from './GererSignalement.vue';
import { useAdminStore } from '../stores/admin'

const adminStore = useAdminStore()
onMounted(async () => {
    await adminStore.getSignalements(1)
})
</script>

<template>
<article v-if="true" class="flex items-center flex-col gap-6 p-6">
    <h2 class="text-orange-400 text-xl">Aucune nouvelle bouteille saq</h2>
    <div>tout est bon pour l'instant</div>
</article>
<article v-else-if="!adminStore.bouteilleACorriger?.id" class="grid gap-6 lg:gap-10 lg:grid-cols-3 md:gap-10 md:grid-cols-2">
    chargement...        
</article>

</template>