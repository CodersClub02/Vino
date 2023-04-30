<script setup>
import { watch, toRefs } from 'vue';
const props = defineProps({
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

let afficherErreur = false
const { erreur } = toRefs(props);

watch(erreur, (currentState, prevState) => {
    afficherErreur = true
}, { deep: true })

</script>


<template>
    <div>
        <div class="flex items-center justify-between">
            <label class="text-sm leading-6 text-gray-900 font-semibold">{{ label }}</label>
        </div>

        <div class="mt-2">
            <select v-bind="$attrs" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
                class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6">
                <option disabled value="" selected>Sélectionnez une option</option>
                <option v-for="(option, index) in options" :key="index" :value="option.id || option">
                    {{ option.nom || option }}
                </option>
            </select>
        </div>
        <span v-if="erreur && afficherErreur" class="text-red-400 min-h-2 text-sm py-2 block">{{ erreur[0] }}</span>
    </div>
</template>


<style>
/* Ajoutez vos styles personnalisés ici, ou utilisez les classes de Tailwind pour personnaliser le composant */
</style>