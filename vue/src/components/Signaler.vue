<script setup>
/**
 * @author Hanane
 * @description Formulaire pour signaler une erreur dans les informations une bouteille du saq
 */

import { ref } from 'vue';
import { useAppStore } from '../stores/app'
import Button from "../components/Button.vue"
import SecButton from "../components/SecButton.vue"
import Textarea from './Textarea.vue';

const appStore = useAppStore()



const signaler = ref({
    anomalie: appStore.bouteilleASignaler.anomalie,
    id: appStore.bouteilleASignaler.id,
})
</script>

<template>
    <div class="w-full bg-gray-900/10 fixed z-10 inset-0 flex justify-center items-center">

        <form @submit.prevent="appStore.signalerErreur(signaler), $emit('cacherFormSignaler')"
            class="flex gap-16 flex-col max-w-md w-full bg-white p-5 ">
            <span>Vous avez trouvé une erreur pour cette bouteille? Merci de nous la mentionner dans le champ suivant</span>

            <Textarea v-bind:erreur="appStore.erreursSignaler.anomalie" v-model="signaler.anomalie" label="Anomalie"
                name="anomalie" />

            <div class="flex gap-4 justify-between">
                <Button texteBouton="Envoyer" />
                <SecButton texteBouton="Annuler" @click="appStore.togglerFormSignaler()"
                    class="bg-gray-400 text-gray-900" />
            </div>

        </form>

    </div>
</template>