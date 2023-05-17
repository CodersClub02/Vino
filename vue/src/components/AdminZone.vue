<script setup>
import { ref } from "vue";
import Membres from "./Membres.vue";
import Signalements from "./Signalements.vue";
import ChargerBouteillesSaq from "./ChargerBouteillesSaq.vue";

const zone = ref('signalements');
</script>

<template>
    <header class="flex bg-white shadow   px-4 py-6 sm:px-6 lg:px-8 w-full">

        <label @click="zone = 'signalements'"
            :class="[zone == 'signalements' ? 'bg-gray-100 text-rose-800 font-semibold' : '', 'flex  gap-2  px-4 py-2 text-sm']"
            class="cursor-pointer">signalements
        </label>

        <label @click="zone = 'membres'"
            :class="[zone == 'membres' ? 'bg-gray-100 text-rose-800 font-semibold' : '', 'flex  gap-2  px-4 py-2 text-sm']"
            class="cursor-pointer">membres
        </label>

        <label @click="zone = 'bouteillesaq'"
            :class="[zone == 'bouteillesaq' ? 'bg-gray-100 text-rose-800 font-semibold' : '', 'flex gap-2 px-4 py-2 text-sm']"
            class="cursor-pointer">importer
        </label>

    </header>

    <div class="mx-auto max-w-7xl flex min-h-full flex-1 flex-col justify-center px-6 py-12">
        <Signalements v-if="zone == 'signalements'" />
        <Membres v-else-if="zone == 'membres'" />
        <ChargerBouteillesSaq v-else />
    </div>
</template>