<script setup>
defineProps({
    titre: {
        type: String,
        default: "Aucun titre"
    }
})
</script>

<template>
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl mt-10 tracking-tight text-gray-600 font-semibold font-title">{{ titre }}</h1>
        </div>
    </header>
</template>