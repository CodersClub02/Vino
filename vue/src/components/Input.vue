<script setup>
defineProps({
    label: {
        type: String,
        default: "label"
    },
    modelValue: {
        type: String,
        default: "modelvalue"
    },
    erreur: {
        type: Array,
        default: []
    },

})
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
                @input="$emit('update:modelValue', $event.target.value)"
                class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6" />
        </div>
        <div v-if="erreur" class="mt-2">
            <span class="text-red-400 text-sm m-2 p-2">{{ erreur[0] }}</span>
        </div>
    </div>
</template>