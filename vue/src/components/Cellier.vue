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
    await appStore.getBouteillesCellier(localStorage.getItem('cellier_id'))
})

const supprimerCellierForm = ref(false)


// const cleTriage = ref([
//     { id: 'id', nom: 'id' }, { id: 'created_at', nom: 'crée' }, { id: 'updated_at', nom: 'modifié' }, { id: 'type_id', nom: 'type' }, { id: 'pays_id', nom: 'pays' }, { id: 'nom', nom: 'nom' }, { id: 'format', nom: 'format' }, { id: 'prix_saq', nom: 'prix saq' }, { id: 'date_achat', nom: 'date achat' }, { id: 'garder_jusqu_a', nom: 'garder jusqu à' }, { id: 'notes', nom: 'notes' }, { id: 'prix_paye', nom: 'prix payé' }, { id: 'quantite', nom: 'quantité' }, { id: 'mellisme', nom: 'méllisme' }, { id: 'pays', nom: 'pays' }, { id: 'type', nom: 'type' }
// ])

const cleTriage = ref([
    { id: 'type_id', nom: 'type' }, { id: 'pays_id', nom: 'pays' }, { id: 'mellisme', nom: 'méllisme' }, { id: 'prix_paye', nom: 'prix payé' }, { id: 'date_achat', nom: 'date achat' }, { id: 'nom', nom: 'nom' }
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
    <header v-if="appStore.celliers.length >= 1" class="flex items-center gap-4 bg-gray-100 p-5">
        <div class="grow flex gap-5 overflow-x-auto text-gray-600 snap-x p-3">
            <span v-for="(cellier) in appStore.celliers"
                class="cursor-pointer flex-none bg-white rounded w-300 shadow-md p-2 snap-center text-xl"
                :class="{ 'bg-rose-400/10' : appStore.cellierSelectione?.id === cellier.id }"
                @click="appStore.getBouteillesCellier(cellier)">
                {{ cellier.nom }}
                <!-- <span class="block text-sm text-gray-500">{{ cellier.contenirs_count }}</span> -->
            </span>
        </div>
        <font-awesome-icon icon="fa-solid fa-circle-plus" @click="appStore.togglerFormCellier('nouveau')" class="text-gray-400 cursor-pointer text-4xl shadow-md" />
    </header>

    <div class="grid text-gray-600 p-5 gap-10">

        <label v-if="!appStore.afficherFormBouteille" @click="appStore.togglerFormBouteille()"
            class="fixed z-10 bottom-32 right-2 shadow-lg bg-rose-300/50 w-16 aspect-square rounded-full flex items-center justify-center cursor-pointer">
            <img src="/ajouter-bouteille.svg" class="w-8">
        </label>

        <form v-if="supprimerCellierForm" @click.self="supprimerCellierForm = false"
            @submit.prevent="appStore.gererCellier(), supprimerCellierForm = false"
            class="flex flex-col gap-6 items-center justify-center fixed bg-black/50 p-4 z-10 inset-0">
            <div class="space-y-6 bg-black/80 p-8 rounded-md">
                <div class="text-center text-xl text-gray-300">Êtes-vous sûr de supprimer <b>{{ appStore.cellierSelectione?.nom }}</b> ?
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
            class="flex gap-6 justify-between items-center border-b-2 px-3">
                <div class="text-2xl font-title font-semibold text-rose-800">
                    {{ appStore.cellierSelectione?.nom }}
                </div>
                <div class="flex gap-10">
                    <font-awesome-icon icon="fa-solid fa-trash" class="text-gray-400 cursor-pointer text-xl"
                        @click="supprimerCellierForm = !supprimerCellierForm" />

                    <font-awesome-icon icon="fa-solid fa-pen-to-square"
                        @click="appStore.togglerFormCellier()"
                        class="text-gray-400 cursor-pointer text-xl" />
            </div>
        </div>


        <template v-if="appStore.afficherFormBouteille">
            <GererBouteille :erreur="authStore?.erreursBouteille" :cellier="appStore.cellierSelectione"
                @cacherFormBouteille="appStore.togglerFormBouteille()" />
        </template>

        <template v-else-if="appStore.rechercheActive">
            Résultat de recherche: 
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
                ">Aucune bouteille dans <em class="text-3xl font-semibold"> {{ appStore.cellierSelectione?.nom }} </em></span>
                <img src="/aucune-bouteille.png" alt="Aucune bouteille" class="w-full">
            </template>

            <div v-else class="grid gap-12 lg:gap-10 lg:grid-cols-4 md:gap-10 md:grid-cols-2">
                <Bouteille v-for="(bouteille) in appStore.mesBouteilleCellier" :bouteille="bouteille" />
            </div>
        </template>

    </div>

    <nav v-if="!appStore.afficherFormBouteille && appStore.cellierSelectione?.nom" class="fixed bottom-0 bg-rose-900/75 py-5 px-5 flex justify-between p-3 w-full gap-3 mt-2">

            <input @input="appStore.rechercherBouteilles($event.target.value)" placeholder="rechercher bouteille..." type="text"
                class="grow max-w-lg rounded-3xl border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6">

            <select @input="trierMesBouteilles($event.target.value)"
                class="w-16 flex justify-center items-center text-gray-700 rounded cursor-pointer p-1">
                <option value="" selected>trier</option>
                <option v-for="(tri) in cleTriage" :value="tri.id">{{ tri.nom }}</option>
            </select>
    </nav>
</template>
