<script setup>
/**
 * @author Hanane
 * @description Formulaire ajout de bouteille
 */

import { ref } from 'vue';
import { useAuthStore } from '../stores/auth'
import Button from "../components/Button.vue"

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

                        <div>
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nom</label>
                            <div class="mt-2">
                                <input id="name" name="nom" v-model="form.nom" type="text"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-rose-500 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="authStore.erreurs.name" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.name[0] }}</span>

                            </div>
                        </div>

                        <!-- Champ Note -->
                        <div>
                            <label for="note" class="block text-sm font-medium leading-6 text-gray-900">Note</label>
                            <div class="mt-2">
                                <select id="note" name="note" v-model="form.note"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6">
                                    <option value="" disabled selected>Choisissez une note</option>
                                    <option value="1">1 étoile</option>
                                    <option value="2">2 étoiles</option>
                                    <option value="3">3 étoiles</option>
                                    <option value="4">4 étoiles</option>
                                    <option value="5">5 étoiles</option>
                                </select>
                            </div>
                            <div v-if="authStore.erreurs.note" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.note[0] }}</span>
                            </div>
                        </div>

                        <!-- Champ Quantité -->
                        <div>
                            <label for="quantite" class="block text-sm font-medium leading-6 text-gray-900">Quantité</label>
                            <div class="mt-2">
                                <input id="quantite" name="quantite" type="number" v-model="form.quantite"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6">
                            </div>
                            <div v-if="authStore.erreurs.note" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.note[0] }}</span>
                            </div>
                        </div>

                        <!-- Champ Méllisme -->
                        <div>
                            <label for="mellisme" class="block text-sm font-medium leading-6 text-gray-900">Méllisme</label>
                            <div class="mt-2">
                                <select id="mellisme" name="mellisme" v-model="form.mellisme"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6">
                                    <option value="" disabled selected>Choisissez une année</option>
                                    <option value="1">1990</option>
                                    <option value="1">1990</option>
                                    <option value="1">1990</option>
                                    <option value="1">1990</option>
                                </select>
                            </div>
                            <div v-if="authStore.erreurs.note" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.note[0] }}</span>
                            </div>
                        </div>

                        <div>
                            <label for="date_achat" class="block text-sm font-medium leading-6 text-gray-900">Date
                                d'achat</label>
                            <div class="mt-2">
                                <input id="date_achat" name="date_achat" v-model="form.date_achat" type="date"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="authStore.erreurs.date_achat" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.date_achat[0] }}</span>
                            </div>
                        </div>

                        <div>
                            <label for="garder_jusqu_a" class="block text-sm font-medium leading-6 text-gray-900">Garder
                                jusqu'à</label>
                            <div class="mt-2">
                                <input id="garder_jusqu_a" name="garder_jusqu_a" v-model="form.garder_jusqu_a" type="date"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="authStore.erreurs.garder_jusqu_a" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.garder_jusqu_a[0] }}</span>
                            </div>
                        </div>

                        <div>
                            <label for="prix_paye" class="block text-sm font-medium leading-6 text-gray-900">Prix</label>
                            <div class="mt-2">
                                <input id="prix_paye" name="prix_paye" v-model="form.prix_paye" type="number" step="0.01"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="authStore.erreurs.prix_paye" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.prix_paye[0] }}</span>
                            </div>
                        </div>

                        <Button texteBouton="Sauvegarder" />
                    </form>
                </div>
            </div>
        </div>
    </main>
</template>