<script setup>
defineProps({
    texteBouton: {
        type: String
    }
})
</script>

<template>
    <label
        class="cursor-pointer bg-white flex min-w-min justify-center rounded-md text-rose-400 border-2 border-rose-400 px-3 p-3 text-sm font-semibold leading-6 shadow-sm hover:bg-rose-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-800">{{ texteBouton }}</label>
</template>
