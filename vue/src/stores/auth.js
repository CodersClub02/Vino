import { defineStore } from "pinia";

import axios from "axios";

export const useAuthStore = defineStore("auth", {

    /**
     * @returns void
     * @author Saddek
     * @description initialise les donneé usager et erreurs de connexion...
     */
    state: () => ({
        authUser: null,
        authErreurs: []
    }),

    /**
     * la facon pinia pour accéder au données depuis l'extérieur de ce module
     * @author Saddek
     */
    getters: {
        user: (state) => state.authUser,
        erreurs: (state) => state.authErreurs
    },

    /**
     * fonctions pour interager avec cet module pinia depuis l'exterieur
     * @author Saddek , Hanane
     */
    actions: {
        /**
         * @author Saddek
         * @returns void
         * @description retrouver les token de csrf depuis le serveur Laravel API.
         * Ce token est renvoyé au serveur dans les requetes subsequentes 
         * dans la cookie du navigateur. On peut changer ce comportement
         * sur le serveur Laravel.
         */
        async getToken() {
            await axios.get('/sanctum/csrf-cookie')
        },

        /**
         * @author Saddek
         * @returns void
         * @description retrouve les données d'usager connecté depuis le serveur
         */
        async getUser() {
            await this.getToken()
            try {
                const donnees = await axios.get('/api/user')
                this.authUser = donnees.data
            } catch (error) {

            }
        },

        /**
         * @author Saddek
         * @param {*} donnees
         * @returns void
         * @description etablir la session entre le navigateur et le serveur API
         * en utilisant les cookies 
         */
        async connecter(donnees) {
            this.authErreurs = []
            try {
                await this.getToken()
                await axios.post('/login', {
                    email: donnees.courriel,
                    password: donnees.mot_de_passe
                })
                await this.getUser()
                // aller dans la page d'accueil
                this.router.push({ name: 'Accueil' });
            } catch (error) {

                if (error.response.status == 404) {
                    //to be reviewed
                    this.authErreurs = error.response.data.message
                } else if (error.response.status == 422) {
                    this.authErreurs = error.response.data.errors
                }

            }
        },

        /**
         * @author Hanane
         * @returns void
         * @description terminer la session sur le serveur: détruire les cookies
         * de connexion entre navigateur et serveur
         */
        async deconnecter() {
            await axios.post('/logout')
            this.authUser = null
        },

        /**
         * @author Hanane
         * @param {*} donnees 
         * @returns void
         * @description interrogir le serveur pour la création du compte 
         * utilisateur et gestion des erreurs de données entrées
         */
        async creerCompte(donnees) {
            this.authErreurs = []
            await this.getToken()
            try {
                await axios.post('/register', {
                    name: donnees.nom,
                    email: donnees.courriel,
                    password: donnees.mot_de_passe,
                    password_confirmation: donnees.confirmer_mot_de_passe
                })
                await this.getUser()
                this.router.push({ name: 'Accueil' })

            } catch (error) {
                if (error.response.status == 422) {
                    this.authErreurs = error.response.data.errors
                }
            }


        },

            /**
     * @author Hanane
     * @param {*} donnees 
     * @returns void
     * @description modification des données d'utilisateurs sur le serveur
     * et gestion des erreurs de saisie
     */

    async modifierCompte(donnees) {
        this.authErreurs = []
        await this.getToken()
        try {
            await axios.put('/update', {
                name: donnees.nom,
            })

        } catch (error) {
            if (error.response.status == 422) {
                this.authErreurs = error.response.data.errors
            }
        }
    }
    },
})