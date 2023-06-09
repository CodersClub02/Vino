<script setup>
import { ref, onMounted } from 'vue';
import Input from './Input.vue';
import Button from './Button.vue';
import SecButton from './SecButton.vue';
import GererCellier from '../components/GererCellier.vue';
import GererBouteille from '../components/GererBouteille.vue';
import Bouteille from '../components/Bouteille.vue';
import Filtre from '../components/Filtre.vue';
import Signaler from "./Signaler.vue";
import Chargement from './Chargement.vue';
import { useAppStore } from '../stores/app';


const appStore = useAppStore()
onMounted(async () => {
    await appStore.getCelliers()
    await appStore.getBouteillesCellier()
})

const supprimerCellierForm = ref(false)
const modeRecherche = ref(false)
const modeArchive = ref(false)
let motCle = ref(null)
const cleTriage = ref([
    { id: 'type_id', nom: 'type' }, { id: 'pays_id', nom: 'pays' }, { id: 'millesime', nom: 'millesime' }, { id: 'prix_paye', nom: 'prix payé' }, { id: 'date_achat', nom: 'date d\'achat' }, { id: 'nom', nom: 'nom' }
])

const trierMesBouteilles = (par) => {
    if (modeRecherche.value == false) {
        appStore.getBouteillesCellier(undefined, par)
    } else {
        appStore.rechercherBouteilles(motCle.value, par)
    }
}

const modeFiltre = ref(false)
const afficherFiltre = ref(false)
</script>

<template>
    <Chargement :estActive="appStore.chargement" />
    <!-- Aucun cellier -->

    <div v-if="!appStore.afficherForm && !appStore.afficherFormBouteille && appStore.celliers.length == 0"
        class="grid p-5 gap-10 content-center max-w-sm m-auto">
        <div class="flex flex-col gap-7 justify-center text-gray-600 mt-10 text-lg">
            Vous n'avez aucun cellier. Créer un pour gérer vos bouteilles de vin.
            <img src="/aucun-cellier.gif" class="">
            <Button texte-bouton="Créer cellier" @click="appStore.togglerFormCellier('nouveau')" />
        </div>

    </div>
    <GererCellier v-if="appStore.afficherForm" />

    <!--  -->
    <header v-if="!modeArchive && !modeRecherche && !appStore.afficherFormBouteille && appStore.celliers.length >= 1"
        class="flex items-center gap-4 p-5">
        <div class="grow flex gap-5 bg-gray-200 rounded overflow-x-auto text-gray-600 snap-x p-3">

            <span v-for="(cellier) in appStore.celliers"
                class="cursor-pointer flex-none rounded w-300 shadow-md p-2 snap-center text-xl"
                :class="appStore.cellierSelectione?.id === cellier.id ? 'bg-rose-400/10' : 'bg-white'"
                @click="appStore.getBouteillesCellier(cellier)">
                {{ cellier.nom }}
            </span>
        </div>

        <img src="/icones/ajouter.svg" @click="appStore.togglerFormCellier('nouveau')"
            class="cursor-pointer drop-shadow w-9 h-9" />

        <img src="/icones/archive.svg" @click="appStore.getBouteillesArchive(), modeArchive = !modeArchive"
            class="cursor-pointer drop-shadow w-9 h-9" />

    </header>

    <div class="grid text-gray-600 p-5 gap-10">

        <label v-if="appStore.celliers.length >= 1 && !appStore.afficherFormBouteille"
            @click="appStore.togglerFormBouteille()"
            class="fixed z-10 bottom-16 right-2 shadow-lg bg-rose-300/50 w-16 aspect-square rounded-full flex items-center justify-center cursor-pointer">
            <img src="/icones/ajouter-bouteille.svg" class="w-8">
        </label>

        <form v-if="supprimerCellierForm" @click.self="supprimerCellierForm = false"
            @submit.prevent="appStore.gererCellier(), supprimerCellierForm = false"
            class="flex flex-col gap-6 items-center justify-center fixed bg-black/50 p-4 z-10 inset-0">
            <div class="space-y-6 bg-black/80 p-8 rounded-md">
                <div class="text-center text-xl text-gray-300">Êtes-vous sûr de supprimer
                    <b>{{ appStore.cellierSelectione?.nom }}</b> ?
                </div>
                <div v-if="appStore.cellierSelectione.contenirs_count>0 && appStore.celliers>1" class="flex flex-col items-center gap-5 p-4 bg-slate-300/5 text-gray-300">
                    <span>
                        cellier {{ appStore.cellierSelectione.nom }} contient {{ appStore.cellierSelectione.contenirs_count }}. selectionez un autre cellier ou déplacer ces bouteilles?
                    </span>
                    <select @input="appStore.deplacerBouteille($event.target.value), supprimerCellierForm = false"
                        class="flex justify-center items-center text-gray-700 rounded cursor-pointer px-2 h-10 bg-gray-200">
                        <option value="" selected>déplacez</option>
                        <option v-for="(cellier) in appStore.celliers.filter((fltr)=> fltr.nom != appStore.cellierSelectione.nom)" :value="cellier.id">{{ cellier.nom }}</option>
                    </select>
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

        <div v-if="appStore.afficherFormArchiverBouteille" @click.self="appStore.togglerFormArchiverBouteille()"
            @submit.prevent="appStore.archiverBouteille()"
            class="flex flex-col gap-6 items-center justify-center fixed bg-black/50 p-4 z-10 inset-0">
            <div class="space-y-6 bg-black/80 p-8 rounded-md">
                <div class="text-center text-xl text-gray-300">Voulez-vous archiver ou supprimer
                    <b>{{ appStore.bouteilleSelectione.nom }}</b> ?
                </div>
                <div class="flex gap-4 whitespace-nowrap justify-between">
                    <Button texteBouton="Archiver" @click="appStore.archiverBouteille()" />
                    <Button texteBouton="Supprimer"
                        @click="appStore.supprimerBouteille(), appStore.togglerFormArchiverBouteille()" />
                    <SecButton texteBouton="Annuler" @click="appStore.togglerFormArchiverBouteille()" />
                </div>
            </div>
        </div>


        <div v-if="!modeArchive && !modeRecherche && !appStore.afficherFormBouteille && appStore.celliers.length >= 1 && !appStore.afficherForm && !supprimerCellierForm"
            class="flex gap-6 justify-between items-center border-b-2 px-3">
            <div class="text-2xl font-title font-semibold text-rose-800">
                {{ appStore.cellierSelectione?.nom }}
            </div>
            <div class="flex gap-10">
                <img src="/icones/supprimer.svg" class="w-5 cursor-pointer "
                    @click="supprimerCellierForm = !supprimerCellierForm" />

                <img src="/icones/modifier.svg" @click="appStore.togglerFormCellier()" class="cursor-pointer w-5" />
            </div>
        </div>

        <template v-else-if="modeRecherche">

            <div class="flex flex-col gap-2">
                <span class="flex gap-2 items-center justify-end">
                    <select @input="trierMesBouteilles($event.target.value)"
                        class="w-24 flex justify-center items-center text-gray-700 rounded cursor-pointer px-2 h-10 bg-gray-200">
                        <option value="" selected>trier par</option>
                        <option v-for="(tri) in cleTriage" :value="tri.id">{{ tri.nom }}</option>
                    </select>
                </span>
                Résultat de recherche:
            </div>

            <div v-if="!appStore.resultatRecherche.length">
                <span class="">Aucune bouteille trouvée</span>
            </div>

            <div v-else class="grid gap-6 lg:gap-10 lg:grid-cols-4 md:gap-10 md:grid-cols-2">
                <Bouteille v-for="(bouteille) in appStore.resultatRecherche" :bouteille="bouteille" />
            </div>

        </template>

        <template v-if="appStore.afficherFormBouteille">
            <GererBouteille :erreur="authStore?.erreursBouteille" :cellier="appStore.cellierSelectione"
                @cacherFormBouteille="appStore.togglerFormBouteille()" />
        </template>


        <template v-else-if="modeFiltre">
            <div class="flex flex-col gap-2">
                <span class="flex gap-2 items-center justify-end">
                    <select @input="trierMesBouteilles($event.target.value)"
                        class="w-24 flex justify-center items-center text-gray-700 rounded cursor-pointer px-2 h-10 bg-gray-200">
                        <option value="" selected>trier par</option>
                        <option v-for="(tri) in cleTriage" :value="tri.id">{{ tri.nom }}</option>
                    </select>

                    <label @click="modeFiltre = false, afficherFiltre = false, appStore.getBouteillesCellier()"
                        class="cursor-pointer w-10 flex justify-center items-center text-gray-700 rounded px-2 h-10 bg-gray-200">
                        <img src="/icones/annuler-filtre.svg" class="w-6 cursor-pointer">
                    </label>
                </span>
                Résultat de filtre:
            </div>
            <div v-if="!appStore.mesBouteilleCellier.length">
                <span class="">Aucune bouteille trouvée</span>

            </div>

            <div v-else class="grid gap-6 lg:gap-10 lg:grid-cols-4 md:gap-10 md:grid-cols-2">
                <Bouteille v-for="(bouteille) in appStore.mesBouteilleCellier" :bouteille="bouteille" />
            </div>

        </template>

        <template v-else-if="!modeRecherche && !modeFiltre && appStore.celliers.length >= 1">
            <template v-if="!appStore.mesBouteilleCellier.length">
                <span class=" text-xl text-black  inset-0  flex flex-col justify-center items-center
                ">
                <template v-if="!modeArchive">
                Aucune bouteille dans <em class="text-xl font-semibold"> {{ appStore.cellierSelectione?.nom }}
                    </em>
                </template>
                <template v-else>
                    Aucune bouteille archivée
                    <SecButton texteBouton="retourner" @click="appStore.getBouteillesCellier(), modeArchive=false" class="w-32 mt-10"/>

                </template>
                </span>
                <img src="/aucune-bouteille.png" class="max-w-lg w-full m-auto">
            </template>


            <template v-else>
                <div v-if="modeArchive" class="flex items-center gap-5 mt-16 p-2 border-b-2">

                    
                    <img src="/icones/cacher-archive.svg"
                        @click="appStore.getBouteillesCellier(), modeArchive = !modeArchive"
                        class="cursor-pointer drop-shadow w-9 h-9" />
                    <h1 class="text-2xl font-title font-semibold text-rose-800">Archive</h1>

                </div>
                <div v-else class="flex justify-end gap-5">
                    <select @input="trierMesBouteilles($event.target.value)"
                        class="w-24 flex justify-center items-center text-gray-700 rounded cursor-pointer px-2 h-10 bg-gray-200">
                        <option value="" selected>trier par</option>
                        <option v-for="(tri) in cleTriage" :value="tri.id">{{ tri.nom }}</option>
                    </select>
                    <label @click="modeFiltre = true, afficherFiltre = true"
                        class="cursor-pointer w-10 flex justify-center items-center text-gray-700 rounded px-2 h-10 bg-gray-200">
                        <img src="/icones/filtre.svg" class="w-6">
                    </label>
                </div>
                <div class="grid gap-6 lg:gap-10 lg:grid-cols-4 md:gap-10 md:grid-cols-2">
                    <Bouteille v-for="(bouteille) in appStore.mesBouteilleCellier" :bouteille="bouteille" />
                </div>
            </template>
        </template>

        <Filtre v-if="afficherFiltre" @cacherFormFiltre="afficherFiltre = false" />

    </div>

    <template v-if="appStore.celliers.length >= 1">
        <label v-if="!modeRecherche" @click="modeRecherche = !modeRecherche, modeFiltre = false"
            class="fixed bottom-2 left-2 bg-rose-900/25 h-10 w-10 rounded-full flex justify-center items-center">
            <img src="/icones/rechercher.svg" class=" h-6 block">
        </label>
        <nav v-if="modeRecherche && !appStore.afficherFormBouteille && appStore.cellierSelectione?.nom"
            class="flex gap-3 items-center fixed bottom-0 bg-rose-900/75 py-2 px-3 w-full">

            <label @click="modeRecherche = !modeRecherche, modeFiltre = false"
                class="bg-rose-900/25 h-10 w-10 rounded-full flex justify-center items-center">
                <img src="/icones/cacher-recherche.svg" class="h-6 block">
            </label>
            <input @input="appStore.rechercherBouteilles($event.target.value), motCle = $event.target.value"
                placeholder="rechercher bouteille..." type="text"
                class="grow max-w-lg rounded-3xl border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6 m-auto">
        </nav>
    </template>
    <Signaler v-if="appStore.bouteilleASignaler?.id" />
</template>