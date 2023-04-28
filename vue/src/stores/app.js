import { defineStore } from "pinia";

import axios from "axios"

export const useAppStore = defineStore("app", {

    /**
     * @returns void
     * @author Hanane
     * @description initialiser les données de l'application et erreurs
     */

    state: () => ({
        mesCelliers: null,
        mesBouteilleCellier: [],
        cellierErreurs: [],
        afficherFormCellier: false,
        affchFormBouteille: false,
        bouteilleErreurs: [],
    }),

    /**
     * Accéder aux données depuis l'extérieur de ce module
     * @author Hanane
     */

    getters: {
        celliers: (state) => state.mesCelliers,
        erreursCellier: (state) => state.cellierErreurs,
        afficherForm: (state) => state.afficherFormCellier,
        afficherFormBouteille: (state) => state.affchFormBouteille,
        erreursBouteille: (state) => state.bouteilleErreurs,
    },

    actions: {
        
        /**
         * @author Saddek
         * @returns void
         * @description cacher et afficher le formulaire de bouteille
         */
        async togglerFormBouteille() {
            this.affchFormBouteille = !this.affchFormBouteille
        },

                /**
         * @author Hanane
         * @returns void
         * @description ajouter bouteille
         */
        async ajouterBouteille(donnees) {

            try {

                await axios.post('/api/contenir', {
                    donnees
                })

                this.togglerFormBouteille()
                this.getBouteillesCellier(donnees.cellier_id)

            } catch (error) {
                this.bouteilleErreurs = error.response.data.errors
            }

        },
        /**
         * @author Saddek
         * @returns void
         * @description cacher et afficher le formulaire de cellier
         */
        async togglerFormCellier() {
            this.afficherFormCellier = !this.afficherFormCellier
        },

        /**
         * @author Hanane
         * @returns void
         * @description retrouver la liste des celliers d'un usager connecté depuis le serveur
         */
        async getCelliers() {
            try {
                const donnees = await axios.get('/api/cellier')
                this.mesCelliers = donnees.data
            } catch (error) {
                this.cellierErreurs = error.response.data.errors
            }
        },

        async gererCellier(donnees) {
            try {
                await axios.post('/api/cellier', {
                    nom: donnees.nom
                })
                this.togglerFormCellier()
                this.getCelliers()

            } catch (error) {
                this.cellierErreurs = error.response.data.errors
            }
        },

        /**
         * @author Hanane
         * @returns void
         * @description retrouver la liste des celliers d'un usager connecté depuis le serveur
         */
        async getBouteillesCellier(idCellier) {
            this.mesBouteilleCellier = []
            try {
                const donnees = await axios.get(`/api/contenir/`)
                this.mesBouteilleCellier = donnees.data
                console.log("helleo", this.mesBouteilleCellier);

            } catch (error) {
                this.mesBouteilleCellier = []
            }
        },
        
    },

})