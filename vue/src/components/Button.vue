<script setup>
defineProps({
    texteBouton: {
        type: String
    }
})
</script>

<template>
    <button type="submit"
        class=" w-full justify-center rounded-md bg-rose-800 px-3 p-3 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-rose-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-800">{{ texteBouton }}</button>
</template>
