<script setup>
defineProps({
    estActive: {
        type: Boolean
    }
})
</script>

<template>
    <div class="absolute inset-0 z-20 bg-black/95 transition duration-500" :class="estActive ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'">
        <img src="/chargement.gif" alt="chargement" class="w-48 m-auto mt-48">
    </div>
</template>