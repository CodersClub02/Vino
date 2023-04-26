<script setup>
/**
 * @author Hanane
 * @description Formulaire ajout de bouteille non disponible dans l'inventaire
 * SAAQ sur le serveur
 */

import { ref } from 'vue';
import { useAuthStore } from '../stores/auth'

const authStore = useAuthStore()
const form = ref({
    nom: '',
    type: '',
    pays: '',
    notes: '',
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
                    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Information Bouteille</h2>
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

                        

                        <div>
                            <label for="type" class="block text-sm font-medium leading-6 text-gray-900">Type</label>
                            <div class="mt-2">
                                <select v-model="form.type" id="type" name="type"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300  focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6">
                                    <option disabled value="">Sélectionnez un type</option>
                                    <option value="rouge">Rouge</option>
                                    <option value="blanc">Blanc</option>
                                    <option value="rosé">Rosé</option>
                                    <option value="effervescent">Effervescent</option>
                                </select>
                            </div>
                            <div v-if="authStore.erreurs.type" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.type[0] }}</span>
                            </div>
                        </div>


                        <div>
                            <div class="flex items-center justify-between">
                                <label for="pays" class="block text-sm font-medium leading-6 text-gray-900">Pays</label>
                            </div>
                            <div class="mt-2">
                                <select v-model="form.pays" name="pays" id="pays"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6">
                                    <option disabled value="">Sélectionnez un pays</option>
                                    <option value="canada">Canada</option>
                                    <option value="france">France</option>
                                    <option value="espagne">Espagne</option>
                                    <option value="italie">Italie</option>
                                    <option value="portugal">Portugal</option>
                                </select>
                            </div>
                            <div v-if="authStore.erreurs.pays" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.pays[0] }}</span>

                            </div>
                        </div>

                        <Textarea 
                        v-bind:erreur="authStore.erreurs.description"
                        v-model="form.description"
                        label="Déscription"
                        name="description"
                        type="text"
                        />

                        <div>
                            <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Prix</label>
                            <div class="mt-2">
                                <input id="price" name="price" v-model="form.price" type="number" step="0.01"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="authStore.erreurs.price" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.price[0] }}</span>
                            </div>
                        </div>

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

                        <!-- Champ Format -->
                        <div>
                            <label for="format" class="block text-sm font-medium leading-6 text-gray-900">Format</label>
                            <div class="mt-2">
                                <select id="format" name="format" v-model="form.format"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6">
                                    <option value="" disabled selected>Choisissez un format</option>
                                    <option value="750 ml">750 ml</option>
                                    <option value="1 L">1 L</option>
                                    <option value="1,5 L">1,5 L</option>
                                    <option value="3 L">3 L</option>
                                    <option value="autre">Autre</option>
                                </select>
                            </div>
                            <div v-if="authStore.erreurs.format" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.format[0] }}</span>
                            </div>
                        </div>


                        <div>
                            <button type="submit"
                                class="flex w-full justify-center rounded-md bg-rose-800 px-3 p-3 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-rose-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-800">Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</template>