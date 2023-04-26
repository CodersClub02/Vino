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
        cellierErreurs: []

    }),


    /**
     * Accéder aux données depuis l'extérieur de ce module
     * @author Hanane
     */

    getters: {
        celliers: (state) => state.mesCelliers,
        erreursCellier: (state) => state.cellierErreurs

    },

    /**
         * fonctions pour interager avec cet module pinia depuis l'exterieur
         * @author Hanane
         */
    actions: {
        /**
         * @author Hanane
         * @returns void
         * @description retrouver les token de csrf depuis le serveur Laravel API.
         */
        async getToken() {
            await axios.get('/sanctum/csrf-cookie')
        },

        /**
         * @author Hanane
         * @returns void
         * @description retrouver la liste des celliers d'un usager connecté depuis le serveur
         */
        async getCelliers() {
            await this.getToken()
            try {
                const donnees = await axios.get('/api/cellier')
                this.mesCelliers = donnees.data
                console.log("helleo", this.erreursCellier);

            } catch (error) {
                this.erreursCellier = error.response.data.errors
                console.log("helleo", this.erreursCellier);

            }
        }
    },

})