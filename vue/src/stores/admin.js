import { defineStore } from "pinia";

import axios from "axios";

export const useAdminStore = defineStore("admin", {

    /**
     * @returns void
     * @author Hanane
     * @description initialiser la liste des membres...
     */
    state: () => ({
        laListeMembres: [],
        laListeSignalements: [],
        laBouteilleACorriger: {},
        lesErreursBouteilleAcorriger: [],
    }),

    /**
     * la facon pinia pour accéder au données depuis l'extérieur de ce module
     * @author Hanane
     */
    getters: {
        listeMembres: (state) => state.laListeMembres,
        listeSignalements: (state) => state.laListeSignalements,
        bouteilleACorriger: (state) => state.laBouteilleACorriger,
        erreursBouteilleAcorriger: (state) => state.lesErreursBouteilleAcorriger,

    },

    /**
     * fonctions pour interager avec cet module pinia depuis l'exterieur
     * @author Hanane
     */
    actions: {

        /**
         * @author Hanane
         * @returns void
         * @description Retrouver la liste des membres 
         */
        async getMembres() {
            try {
                const donnees = await axios.get('/api/membres')
                this.laListeMembres = donnees.data
            } catch (error) {

            }
        },

        /**
        * @author Hanane
        * @returns void
        * @description signaler une erreur pour une bouteille saq
        */
        async suspendreMembre(membre) {
            try {
                await axios.put(`/api/membre/${membre.id}`)
            } catch (error) {
            }

        },

        /**
         * @author Saddek
         * @returns void
         * @description Retrouver la liste des signalements des erreurs bouteilles avec membre 
         */
        async getSignalements() {
            try {
                const donnees = await axios.get('/api/signalements')
                this.laListeSignalements = donnees.data
            } catch (error) {

            }
        },
/*
* @author Hanane
* @returns void
* @description ajouter bouteille
*/
        async togglerFormSignalement(donnees) {
            this.laBouteilleACorriger = {}
            if(!donnees) return
            
            try {
                const response = await axios.get(`/api/bouteille/${donnees.bouteille_id}`)
                this.laBouteilleACorriger = response.data
                Object.assign(this.laBouteilleACorriger, donnees)

            } catch (error) {
                this.lesErreursBouteilleAcorriger = error.response.data.errors
            }

        },

        /**
        * @author Saddek
        * @returns void
        * @description signaler une erreur pour une bouteille saq
        */
        async resoudreErreur() {
            try {
                await axios.put('/api/signalements', this.laBouteilleACorriger)
                await this.getSignalements();
                this.togglerFormSignalement()

            } catch (error) {
                this.lesErreursBouteilleAcorriger = error.response.data.errors
            }

        },

        
    }
})