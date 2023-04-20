import { defineStore } from "pinia";

import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: ()=>({
        authUser: null,
        authErrors: []
    }),
    getters: {
        user: (state) => state.authUser,
        errors: (state) => state.authErrors
    },
    actions: {
        async getToken() {
            await axios.get('/sanctum/csrf-cookie');
          },
        async getUser(){
            await this.getToken()
            const donnees = await axios.get('/api/user')
            this.authUser = donnees.data
        },
        async connecter(donnees){
            this.authErrors = []
            try {
                await this.getToken()
                await axios.post('/login', {
                  email: donnees.courriel,
                  password: donnees.mot_de_passe
                })
                // aller dans la page d'accueil
                this.router.push({name: 'Accueil'});                
            } catch (error) {
                
                if(error.response.status == 404) {
                    //to be reviewed
                    this.authErrors = error.response.data.message
                }else if(error.response.status == 422) {
                    this.authErrors = error.response.data.errors
                }

            }
          },
          async deconnecter(){
            await axios.post('/logout')
            this.authUser = null
          }

    }
})