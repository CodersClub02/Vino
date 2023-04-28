<script setup>
import { watch, toRefs } from "vue";
const props = defineProps({
    label: {
        type: String,
        default: "label"
    },
    modelValue: {
        type: String,
        default: ""
    },
    erreur: {
        type: Array,
        default: []
    },
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
            <label :for="$attrs['name']" class="block text-sm font-medium leading-6 text-gray-900">{{ label }}</label>
            <div class="text-sm">
                <slot></slot>
            </div>
        </div>

        <div class="mt-2">
            <input :id="$attrs['name']" v-bind="$attrs" :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value), afficherErreur = false"
                class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6" />
        </div>
        <span v-if="erreur && afficherErreur" class="text-red-400 min-h-2 text-sm py-2 block">{{ erreur[0] }}</span>
    </div>
</template>
