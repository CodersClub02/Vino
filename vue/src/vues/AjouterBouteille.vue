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

                        <Input v-bind:erreur="authStore.erreurs.name" v-model="form.nom" label="Nom" name="nom"
                            type="text" />

                        <Input v-bind:erreur="authStore.erreurs.notes" v-model="form.notes" label="Notes" name="notes"
                            type="text" />

                        <Input v-bind:erreur="authStore.erreurs.quantite" v-model="form.quantite" label="Quantité"
                            name="quantite" type="number" min="1" />


                        <Input v-bind:erreur="authStore.erreurs.mellisme" v-model="form.mellisme" label="Méllisme"
                            name="mellisme" type="number" />

                        <Input v-bind:erreur="authStore.erreurs.date_achat" v-model="form.date_achat" label="Date d'achat"
                            name="date_achat" type="date" />

                        <Input v-bind:erreur="authStore.erreurs.garder_jusqu_a" v-model="form.garder_jusqu_a"
                            label="Garder jusqu'à" name="garder_jusqu_a" type="date" />

                        <Input v-bind:erreur="authStore.erreurs.prix_paye" v-model="form.prix_paye" label="Prix"
                            name="prix_paye" type="date" />

                        <Button texteBouton="Sauvegarder" />

                    </form>
                </div>
            </div>
        </div>
    </main>
</template>