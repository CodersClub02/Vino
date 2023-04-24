<script setup>
/**
 * @author Hanane
 * @description Formulaire ajout de bouteille non disponible dans l'inventaire
 * SAAQ sur le serveur
 */

import { ref } from 'vue';
import { useAuthStore } from '../stores/auth'
import Select from '../components/Select.vue';
import Input from '../components/Input.vue';
import Button from '../components/Button.vue';

const authStore = useAuthStore()
const form = ref({
    nom: '',
    type: '',
    pays: '',
    decription: '',
    prix: '',
    image: '',
    format: ''
});
const type = ref([
    "Rouge", "Rosé", "Blanc", "Effervescent"
])

const pays = ref([
    "Canada", "France", "Italie", "Angleterre"
])

const format = ref([
    "750 ml", "1 L", "1,5 L", "3 L", "autre"
])


</script>

<template>
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Ajouter Bouteille</h1>
        </div>
    </header>
    <main>

        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Information
                        Bouteille</h2>
                </div>

                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form @submit.prevent="authStore.ajouterBouteille(form)" class="space-y-6">

                        <Input v-bind:erreur="authStore.erreurs.nom" v-model="form.nom" label="Nom" name="nom"
                            type="text" />


                        <Select v-model="form.type" name="type" :options="type" v-bind:erreur="authStore.erreurs.type"
                            label="Type" />

                        <Select v-model="form.pays" name="pays" :options="pays" v-bind:erreur="authStore.erreurs.pays"
                            label="Pays" />


                        <div>

                            <div class="flex items-center justify-between">
                                <label for="description"
                                    class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                                <div class="text-sm">
                                </div>
                            </div>
                            <div class="mt-2">
                                <textarea v-model="form.description" id="description" name="description" rows="3"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6"></textarea>
                            </div>
                            <div v-if="authStore.erreurs.description" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.description[0] }}</span>

                            </div>
                        </div>

                        <Input v-bind:erreur="authStore.erreurs.prix" v-model="form.prix" label="Prix" name="prix"
                            type="number" />

                        <!-- Champ Image -->
                        <div>
                            <label for="image" class="block text-sm font-medium leading-6 text-gray-900">Image</label>
                            <div class="mt-2">
                                <input id="image" name="image" type="file"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="authStore.erreurs.image" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.image[0] }}</span>
                            </div>
                        </div>

                        <Select v-model="form.format" name="format" :options="format"
                            v-bind:erreur="authStore.erreurs.format" label="Format" />

                        <Button texteBouton="Sauvegarder" />

                    </form>
                </div>
            </div>
        </div>
    </main>
</template>