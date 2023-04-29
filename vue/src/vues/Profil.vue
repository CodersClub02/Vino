<script setup>
/**
 * @author Hanane, Saddek
 * @description Vue de profil usager
 */

import { ref, onMounted } from 'vue';
import Input from "../components/Input.vue";
import Button from "../components/Button.vue";
import SecButton from "../components/SecButton.vue";
import Entete from "../components/Entete.vue";

import { useAuthStore } from '../stores/auth'

const authStore = useAuthStore()

/**
 * @author Hanane
 * @returns void
 * @description cacher et afficher le formulaire de changement d'information 
 * sur profil
 */
let modifier = ref(false)
function toggleModifier() {
    this.modifier = !this.modifier
}

const form = ref({
    nom: '',
    courriel: '',
    mot_de_passe: '',
    confirmer_mot_de_passe: ''
});

onMounted(async () => {
    form.value.nom = authStore.user.name;
    form.value.courriel = authStore.user.email;
    form.value.mot_de_passe = authStore.user.password;
})
</script>

<template>
 
    <Entete titre="Salut">
        <span class="font-bold text-rose-800">{{ authStore.user.name }}</span>
    </Entete>


    <main>
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 font-title">Mon compte</h2>
                </div>

                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form class="space-y-6">

                        <Input v-bind:erreur="authStore.erreurs.nom" v-model="form.nom" label="Nom" name="nom"
                            type="text" />

                        <Input v-bind:erreur="authStore.erreurs.email" v-model="form.courriel" label="Courriel" name="courriel"
                            type="text" />


                            <Input v-if="modifier" v-bind:erreur="authStore.erreurs.password" v-model="form.mot_de_passe" label="Mot de
                                    Passe" name="mot_de_passe"
                            type="text" />

                            <Input v-if="modifier" v-bind:erreur="authStore.erreurs.password" v-model="form.confirmer_mot_de_passe" label="Confirmez votre mot de
                                    Passe" name="mot_de_passe"
                            type="text" />

                        <div class="flex justify-between">
                            <Button v-if="modifier" texteBouton="Sauvegarder" />
                            <SecButton v-if="modifier" @click="toggleModifier()" texteBouton="Annuler" />
                        <Button v-else @click="toggleModifier()" texteBouton="Modifier" class="w-full" />
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>

</template>