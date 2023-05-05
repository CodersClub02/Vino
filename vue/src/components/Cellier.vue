<script setup>
import { ref, onMounted } from 'vue';
import Input from './Input.vue';
import Button from './Button.vue';
import SecButton from './SecButton.vue';
import GererCellier from '../components/GererCellier.vue';
import GererBouteille from '../components/GererBouteille.vue';
import Bouteille from '../components/Bouteille.vue';
import { useAppStore } from '../stores/app'

const appStore = useAppStore()

onMounted(async () => {
    await appStore.getCelliers()
    if (appStore.celliers.length > 0) {
        form = appStore.celliers[0]
        form.nomEnCours = form.nom
    }
    await appStore.getBouteillesCellier(form.id)
})

let form = ref({
    nom: null,
    id: null
})

const supprimerCellierForm = ref(false)


const cleTriage = ref([
    { id: 'id', nom: 'id' }, { id: 'created_at', nom: 'crée' }, { id: 'updated_at', nom: 'modifié' }, { id: 'type_id', nom: 'type' }, { id: 'pays_id', nom: 'pays' }, { id: 'nom', nom: 'nom' }, { id: 'format', nom: 'format' }, { id: 'prix_saq', nom: 'prix saq' }, { id: 'date_achat', nom: 'date achat' }, { id: 'garder_jusqu_a', nom: 'garder jusqu à' }, { id: 'notes', nom: 'notes' }, { id: 'prix_paye', nom: 'prix payé' }, { id: 'quantite', nom: 'quantité' }, { id: 'mellisme', nom: 'méllisme' }, { id: 'pays', nom: 'pays' }, { id: 'type', nom: 'type' }
])

const trierMesBouteilles = (par) => {
    if (appStore.rechercheActive) {
        appStore.resultatRecherche = appStore.resultatRecherche.sort((a, b) => (a[par] > b[par]) ? 1 : ((b[par] > a[par]) ? -1 : 0))
    } else {
        appStore.mesBouteilleCellier = appStore.mesBouteilleCellier.sort((a, b) => (a[par] > b[par]) ? 1 : ((b[par] > a[par]) ? -1 : 0))
    }

}
</script>

<template>
    <!-- Aucun cellier -->
    <div v-if="appStore.celliers.length == 0" class="grid text-gray-600 p-5 gap-10">

        <template v-if="!appStore.afficherForm">
            <div class="flex flex-col gap-7 justify-center px-6 lg:px-8 sm:mx-auto sm:w-full sm:max-w-sm">
                Vous n'avez aucun cellier. Créer un pour gérer vos bouteilles de vin.
                <Button texte-bouton="Créer cellier" @click="appStore.togglerFormCellier('nouveau')" />
            </div>
            <img src="/aucune-bouteille.png">
        </template>

    </div>
    <GererCellier v-if="appStore.afficherForm" :form="form" @cacherForm="appStore.togglerFormCellier()" />

    <!--  -->
    <div v-if="appStore.celliers.length > 1" class="flex gap-10 bg-gray-100 overflow-x-auto text-gray-600 p-5 ">

        <div v-for="(cellier) in appStore.celliers"
            class="cursor-pointer flex-none bg-white rounded shadow-md p-2 snap-center"
            :class="{ '': form.id == cellier.id }"
            @click="appStore.getBouteillesCellier(cellier.id), form.id = cellier.id, form.nomEnCours = cellier.nom">
            <span>{{ cellier.nom }}</span>
            <span class="block text-sm text-gray-500">{{ cellier.contenirs_count }}</span>
        </div>
    </div>

    <div class="grid text-gray-600 p-5 gap-10">

        <label v-if="!appStore.afficherFormBouteille" @click="appStore.togglerFormBouteille({
            source: 'saq',
            cellier_id: form.id,
        })"
            class="fixed z-10 bottom-32 right-2 shadow-lg bg-rose-300/50 w-12 aspect-square rounded-full flex items-center justify-center">
            <img src="/ajouter-bouteille.svg" class="w-7">
        </label>

        <form v-if="supprimerCellierForm" @click.self="supprimerCellierForm = false"
            @submit.prevent="appStore.gererCellier(form, 'delete'), supprimerCellierForm = false"
            class="flex flex-col gap-6 items-center justify-center fixed bg-black/50 p-4 z-10 inset-0">
            <div class="space-y-6 bg-black/80 p-8 rounded-md">
                <div class="text-center text-xl text-gray-300">Êtes-vous sur de supprimer <b>{{ form.nomEnCours }}</b> ?
                </div>
                <div class="flex gap-4 whitespace-nowrap justify-between">
                    <Button texteBouton="Supprimer" />
                    <SecButton texteBouton="Annuler" @click="supprimerCellierForm = false" />
                </div>
            </div>
        </form>


        <form v-if="appStore.afficherFormSupprimerBouteille" @click.self="appStore.togglerFormSupprimerBouteille()"
            @submit.prevent="appStore.supprimerBouteille()"
            class="flex flex-col gap-6 items-center justify-center fixed bg-black/50 p-4 z-10 inset-0">
            <div class="space-y-6 bg-black/80 p-8 rounded-md">
                <div class="text-center text-xl text-gray-300">Êtes-vous sur de supprimer
                    <b>{{ appStore.bouteilleSelectione.nom }}</b> ?
                </div>
                <div class="flex gap-4 whitespace-nowrap justify-between">
                    <Button texteBouton="Supprimer" />
                    <SecButton texteBouton="Annuler" @click="appStore.togglerFormSupprimerBouteille()" />
                </div>
            </div>
        </form>

        <div v-if="appStore.celliers.length >= 1 && !appStore.afficherForm && !supprimerCellierForm"
            class="flex gap-6 justify-between items-center border-b-2 px-3 ">
            <div class="flex gap-6 justify-between items-center px-3">
                <div class="text-2xl font-title font-semibold text-rose-800">
                    {{ form?.nomEnCours }}
                </div>
                <div class="flex gap-4">
                    <font-awesome-icon icon="fa-solid fa-trash" class="text-gray-400 cursor-pointer"
                        @click="supprimerCellierForm = !supprimerCellierForm" />

                    <font-awesome-icon icon="fa-solid fa-pen-to-square"
                        @click="appStore.togglerFormCellier(), form.nom = form.nomEnCours"
                        class="text-gray-400 cursor-pointer" />
                </div>
            </div>

            <font-awesome-icon icon="fa-solid fa-circle-plus" @click="appStore.togglerFormCellier('nouveau'), form.nom = ''"
                class="text-gray-400 cursor-pointer" />

        </div>

        <template v-if="appStore.afficherFormBouteille">
            <GererBouteille :erreur="authStore?.erreursBouteille" :cellier="form"
                @cacherFormBouteille="appStore.togglerFormBouteille()" />
        </template>

        <template v-else-if="appStore.rechercheActive">
            La recherche est active
            <div v-if="!appStore.resultatRecherche.length">
                <span class="">Aucune bouteille trouvée</span>
            </div>

            <div v-else class="grid gap-10 lg:gap-10 lg:grid-cols-4 md:gap-10 md:grid-cols-2">
                <Bouteille v-for="(bouteille) in appStore.resultatRecherche" :bouteille="bouteille" />
            </div>

        </template>
        <template v-else>
            <template v-if="appStore.celliers.length >= 1 && !appStore.mesBouteilleCellier.length">
                <span class=" text-2xl text-black  inset-0  flex flex-col justify-center items-center
                ">Aucune bouteille dans <em class="text-3xl font-semibold"> {{ form?.nomEnCours }} </em></span>
                <img src="/aucune-bouteille.png" alt="Aucune bouteille" class="w-full m-auto md:w-1/2 lg:w-1/3 ">
            </template>

            <div v-else class="grid gap-12 lg:gap-10 lg:grid-cols-4 md:gap-10 md:grid-cols-2">
                <Bouteille v-for="(bouteille) in appStore.mesBouteilleCellier" :bouteille="bouteille" />
            </div>
        </template>

    </div>

    <header v-if="form.nomEnCours" class="fixed w-full bottom-0 bg-gray-500 py-1 px-2">
        <div>gérer les bouteilles de: {{ form?.nomEnCours }}</div>
        <nav class="flex justify-between p-3 w-full gap-3 mt-2">

            <input @input="appStore.rechercherBouteilles($event.target.value)" type="text"
                class="grow rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6">

            <select @input="trierMesBouteilles($event.target.value)"
                class="w-16 flex justify-center items-center text-white rounded cursor-pointer border-b-rose-300 bg-purple-400 p-1">
                <option value="" selected>Trier</option>
                <option v-for="(tri) in cleTriage" :value="tri.id">{{ tri.nom }}</option>
            </select>
        </nav>
    </header>
</template>
