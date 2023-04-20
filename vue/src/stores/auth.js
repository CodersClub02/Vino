import { defineStore } from "pinia";

import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        authUser: null,
        authErreurs: []
    }),
    getters: {
        user: (state) => state.authUser,
        erreurs: (state) => state.authErreurs
    },
    actions: {
        async getToken() {
            await axios.get('/sanctum/csrf-cookie');
        },
        async getUser() {
            this.getToken()
            const donnees = await axios.get('/api/user')
            this.authUser = donnees.data
        },
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
                this.router.push('/')

            } catch (error) {
                if (error.response.status == 422) {
                    this.authErreurs = error.response.data.errors
                }


            }
        }


    }
})