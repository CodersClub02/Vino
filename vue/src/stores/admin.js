import { defineStore } from "pinia";

import axios from "axios";

export const useAdminStore = defineStore("admin", {

    /**
     * @returns void
     * @author Hanane
     * @description initialiser la liste des membres...
     */
    state: () => ({
        laListeMembres: []
    }),

    /**
     * la facon pinia pour accéder au données depuis l'extérieur de ce module
     * @author Hanane
     */
    getters: {
        listeMembres: (state) => state.laListeMembres,
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

    }
})