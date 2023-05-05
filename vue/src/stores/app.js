import { defineStore } from "pinia";

import axios from "axios"

export const useAppStore = defineStore("app", {

    /**
     * @returns void
     * @author Hanane
     * @description initialiser les données de l'application et erreurs
     */

    state: () => ({
        mesCelliers: [],
        mesBouteilleCellier: [],
        cellierNouveau: null,
        cellierErreurs: [],
        afficherFormCellier: false,
        affchFormBouteille: false,
        affchFormSupprimerBouteille: false,
        bouteilleErreurs: [],

        laSuggestionsBouteilles: [],
        laListeType: [],
        laListePays: [],

        laBouteilleSelectione: {},
        mesResultatDeRechercheBouteille: [],
        estALarecherche: false
    }),

    /**
     * Accéder aux données depuis l'extérieur de ce module
     * @author Hanane
     */

    getters: {
        rechercheActive: (state) => state.estALarecherche,
        resultatRecherche: (state) => state.mesResultatDeRechercheBouteille,
        celliers: (state) => state.mesCelliers,
        erreursCellier: (state) => state.cellierErreurs,
        nouveauCellier: (state) => state.cellierNouveau,
        afficherForm: (state) => state.afficherFormCellier,
        afficherFormBouteille: (state) => state.affchFormBouteille,
        afficherFormSupprimerBouteille: (state) => state.affchFormSupprimerBouteille,
        erreursBouteille: (state) => state.bouteilleErreurs,
        suggestionsBouteilles: (state) => state.laSuggestionsBouteilles,
        listeType: (state) => state.laListeType,
        listePays: (state) => state.laListePays,
        bouteilleSelectione: (state) => state.laBouteilleSelectione,
    },

    actions: {

        /**
         * @author Saddek
         * @description Remplir la liste des bouteilles interactivement comme
         * l'usager tape le nom de boutteille ou code saq
         */
        async listeSuggestionsBouteilles(requete) {
            try {
                const reponse = await axios.get('/api/bouteille?requete=' + requete)
                this.laSuggestionsBouteilles = reponse.data
            } catch (error) {
                // this.bouteilleErreurs = error.response.data.errors
            }
        },


        /**
        * @author Hanane
        * @description Retrouver la liste des pays
        */
        async getListePays() {
            try {
                const reponse = await axios.get('/api/pays')
                this.laListePays = reponse.data
            } catch (error) {
                return []
            }
        },


        /**
        * @author Hanane
        * @description Retrouver la liste des types
        */
        async getListeType() {
            try {
                const reponse = await axios.get('/api/type')
                this.laListeType = reponse.data
            } catch (error) {
                return []
            }
        },

        /**
         * @author Saddek
         * @returns void
         * @description cacher et afficher le formulaire de bouteille
         */
        async togglerFormBouteille(bouteilleSelectione) {
            this.affchFormBouteille = !this.affchFormBouteille

            bouteilleSelectione.quantite || (bouteilleSelectione.quantite = 1)
            bouteilleSelectione.garder_jusqu_a || (bouteilleSelectione.garder_jusqu_a = 2023)
            bouteilleSelectione.date_achat || (bouteilleSelectione.date_achat = new Date().toISOString().slice(0,10))
            
            this.laBouteilleSelectione = bouteilleSelectione
        },


         /**
         * @author Hanane
         * @returns void
         * @description cacher et afficher le formulaire de suppression de bouteille
         */
        async togglerFormSupprimerBouteille(bouteilleSelectione) {
            this.affchFormSupprimerBouteille = !this.affchFormSupprimerBouteille
            this.laBouteilleSelectione = bouteilleSelectione
        },


        /**
 * @author Hanane
 * @returns void
 * @description ajouter bouteille
 */
        async ajouterBouteille(donnees) {
            try {
                await axios.post('/api/contenir', donnees)

                this.togglerFormBouteille()
                this.getBouteillesCellier(donnees.cellier_id)

            } catch (error) {
                this.bouteilleErreurs = error.response.data.errors
            }

        },


        /**
* @author Hanane
* @returns void
* @description Modifier bouteille
*/
        async modifierBouteille(donnees) {

            try {

                await axios.put(`/api/contenir/${donnees.id}`, donnees)
                this.affchFormBouteille = false

            } catch (error) {
                this.bouteilleErreurs = error.response.data.errors
            }

        },

         /**
* @author Hanane
* @returns void
* @description Supprimer bouteille
*/
        async supprimerBouteille() {

            try {

                await axios.delete(`/api/contenir/${this.laBouteilleSelectione.id}`)
                this.getBouteillesCellier(this.laBouteilleSelectione.cellier_id)
                this.togglerFormSupprimerBouteille()

            } catch (error) {
                this.bouteilleErreurs = error.response.data.errors
            }

        },
        /**
         * @author Saddek
         * @returns void
         * @description cacher et afficher le formulaire de cellier
         */
        async togglerFormCellier(nouveauCellier) {
            this.cellierNouveau = nouveauCellier
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

        async gererCellier(donnees, supprimer) {
            try {
                // Si l'usager veut modifier un cellier
                if (supprimer) {
                    await axios.delete(`/api/cellier/${donnees.id}`)
                }
                // Si l'usager veut modifier un cellier
                else if (this.cellierNouveau) {
                    await axios.post(`/api/cellier/`, {
                        nom: donnees.nom
                    })
                    this.togglerFormCellier()

                    // Si l'usager veut ajouter un cellier
                } else {
                    await axios.put(`/api/cellier/${donnees.id}`, {
                        nom: donnees.nom
                    })
                    this.togglerFormCellier()

                }

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

                const donnees = await axios.get(`/api/cellier/${idCellier}`)
                this.mesBouteilleCellier = donnees.data

            } catch (error) {

                if (error.response.status == 404) {
                    this.mesBouteilleCellier = []
                } else {
                    this.mesBouteilleCellier = { 'erreur': 'un probléme' }
                }

            }
        },
        /**
         * @author Saddek
         * @returns void
         * @description retrouver la liste des bouteille d'un usager connecté depuis le serveur
         */
        async rechercherBouteilles(motCle) {

            this.estALarecherche = motCle.length > 0

            this.mesResultatDeRechercheBouteille = []
            try {
                const donnees = await axios.get(`/api/contenir/`, { params: { recherche: 'oui', mot_cle: motCle } })
                this.mesResultatDeRechercheBouteille = donnees.data
            } catch (error) {

                if (error.response.status == 404) {
                    this.mesResultatDeRechercheBouteille = []
                }

            }
        },

    },

})