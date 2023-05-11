<script setup>
import { ref } from "vue";
import { useAuthStore } from "../stores/auth";
const authStore = useAuthStore()

import Input from "../components/Input.vue";
import Button from "../components/Button.vue";

</script>

<template>
    <header class=" flex bg-white shadow mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        <router-link :to="{ name: 'Profil' }"
            :class="[active ? 'bg-gray-100' : '', 'flex  gap-2  px-4 py-2 text-sm font-semibold']">Membres
        </router-link>

        <router-link :to="{ name: 'Profil' }"
            :class="[active ? 'bg-gray-100' : '', 'flex  gap-2  px-4 py-2 text-sm font-semibold']">Bouteilles
        </router-link>
    </header>

    <div class="mx-auto max-w-7xl flex min-h-full flex-1 flex-col justify-center px-6 py-12">





    </div>
</template>