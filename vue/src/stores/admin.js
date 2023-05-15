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

        async getMembres(page) {

            if(page == this.laListeMembres.page_en_cours) return
            
            try {
                const donnees = await axios.get('/api/membres', {params: {page: page||this.laListeMembres.page_en_cours}})
                this.laListeMembres = donnees.data.data

                Object.assign(this.laListeMembres, this.pagination(donnees.data.current_page, donnees.data.last_page))

            } catch (error) {

            }
        },

        pagination(current_page, last_page) {
            const premiere_page = 1
            const page_precedente = (current_page -1) || 1
            const page_en_cours = current_page
            const page_suivante = ((current_page + 1) >= last_page ? last_page : (current_page + 1))
            const derniere_page = last_page
            return {premiere_page, page_precedente, page_en_cours, page_suivante, derniere_page}
        },

        /**
        * @author Hanane
        * @returns void
        * @description Modifier l'état d'un membre(actif/suspendu)
        */
        async modifierStatutMembre(membre) {
            try {
                await axios.put(`/api/membres/${membre.id}`)
                this.getMembres()
            } catch (error) {
            }

        },

        /**
         * @author Saddek
         * @returns void
         * @description Retrouver la liste des signalements des erreurs bouteilles avec membre 
         */
        async getSignalements(page) {

            if(page === this.laListeSignalements.page_en_cours) return
            
            try {
                const donnees = await axios.get('/api/signalements', {params: {page: page||this.laListeSignalements.page_en_cours}})
                this.laListeSignalements = donnees.data.data

                Object.assign(this.laListeSignalements, this.pagination(donnees.data.current_page, donnees.data.last_page))

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
            if (!donnees) return

            try {
                const response = await axios.get(`/api/bouteille/${donnees.bouteille_id}`)
                this.laBouteilleACorriger = response.data
                Object.assign(this.laBouteilleACorriger, donnees)
                console.log(donnees);

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