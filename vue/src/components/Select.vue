<script setup>
defineProps({
    label: {
        type: String,
        default: "select"
    },

    options: {
        type: Array,
    },

    erreur: {
        type: Array,
        default: []
    }

})

</script>


<template>
    <div>
        <div class="flex items-center justify-between">
            <label class="block text-sm font-medium leading-6 text-gray-900">{{ label }}</label>
        </div>
        <div class="mt-2">
            <select v-bind="$attrs" :value="modelValue"
                class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6">
                <option disabled value="" selected>Sélectionnez une option</option>
                <option v-for="(option, index) in options" :key="index" :value="option">{{ option }}</option>
            </select>
        </div>
        <div v-if="erreur" class="mt-2">
            <span class="text-red-400 text-sm m-2 p-2">{{ erreur[0] }}</span>
        </div>
    </div>
</template>


<style>
/* Ajoutez vos styles personnalisés ici, ou utilisez les classes de Tailwind pour personnaliser le composant */
</style>