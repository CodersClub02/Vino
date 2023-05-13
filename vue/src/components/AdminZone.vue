<script setup>
import { ref } from "vue";
import Membres from "./Membres.vue";

const zone = ref('signalements');
</script>

<template>
    <header class="flex bg-white shadow mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        <label @click="zone = 'signalements'"
            :class="[zone == 'signalements' ? 'bg-gray-100' : '', 'flex  gap-2  px-4 py-2 text-sm']"
            class="cursor-pointer">Signalements
        </label>

        <label @click="zone = 'membres'" :class="[zone == 'membres' ? 'bg-gray-100' : '', 'flex  gap-2  px-4 py-2 text-sm']"
            class="cursor-pointer">Membres
        </label>

    </header>

    <div class="mx-auto max-w-7xl flex min-h-full flex-1 flex-col justify-center px-6 py-12">

        <Membres />

    </div>
</template>