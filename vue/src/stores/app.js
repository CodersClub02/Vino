import { defineStore } from "pinia";

import axios from "axios"

export const useAppStore = defineStore("app", {

    /**
     * @returns void
     * @author Hanane
     * @description initialiser les données de l'application et erreurs
     */

    state: () => ({
        leChargement: false,
        mesCelliers: [],
        leCellierSelectione: [],
        mesBouteilleCellier: [],
        cellierNouveau: null,
        cellierErreurs: [],
        afficherFormCellier: false,
        affchFormBouteille: false,
        affchFormSupprimerBouteille: false,
        affchFormArchiverBouteille: false,
        bouteilleErreurs: [],

        laSuggestionsBouteilles: [],
        laListeType: [],
        laListePays: [],

        laBouteilleSelectione: {},
        mesResultatDeRechercheBouteille: [],
        estALarecherche: false,
        laBouteilleAgerer: 0,

        lErreursSignaler: [],
        laBouteilleASignaler: {},
    }),

    /**
     * Accéder aux données depuis l'extérieur de ce module
     * @author Hanane
     */

    getters: {
        chargement: (state) => state.leChargement,
        resultatRecherche: (state) => state.mesResultatDeRechercheBouteille,
        celliers: (state) => state.mesCelliers,
        erreursCellier: (state) => state.cellierErreurs,
        nouveauCellier: (state) => state.cellierNouveau,
        afficherForm: (state) => state.afficherFormCellier,
        afficherFormBouteille: (state) => state.affchFormBouteille,
        afficherFormSupprimerBouteille: (state) => state.affchFormSupprimerBouteille,
        afficherFormArchiverBouteille: (state) => state.affchFormArchiverBouteille,
        erreursBouteille: (state) => state.bouteilleErreurs,
        suggestionsBouteilles: (state) => state.laSuggestionsBouteilles,
        listeType: (state) => state.laListeType,
        listePays: (state) => state.laListePays,
        bouteilleSelectione: (state) => state.laBouteilleSelectione,
        cellierSelectione: (state) => state.leCellierSelectione,
        bouteilleAgerer: (state) => state.laBouteilleAgerer,
        erreursSignaler: (state) => state.lErreursSignaler,
        bouteilleASignaler: (state) => state.laBouteilleASignaler,

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

        faireValeursBouteilleDefaut(nomBouteille) {
            const cetteBouteille = this.laSuggestionsBouteilles.filter(bout => bout.nom == nomBouteille)[0]
            if (cetteBouteille) {
                this.laBouteilleSelectione.prix_paye = cetteBouteille.prix_saq
            }
        },

        /**
* @author Hanane
* @returns void
* @description afficher ou cacher le formulaire pour signaler une erreur
*/
        togglerFormSignaler(donnees) {
            this.laBouteilleASignaler = donnees;
        },



        /**
* @author Hanane
* @returns void
* @description signaler une erreur pour une bouteille saq
*/
        async signalerErreur(donnees) {
            try {
                await axios.put(`/api/anomalie/${donnees.id}`, donnees)
                this.togglerFormSignaler()

            } catch (error) {
                this.lErreursSignaler = error.response.data.errors
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

        togglerBouteilleAgerer(bouteille_id) {
            this.laBouteilleAgerer = bouteille_id
        },

        /**
         * @author Saddek
         * @returns void
         * @description cacher et afficher le formulaire de bouteille
         */
        async togglerFormBouteille(bouteilleSelectione) {
            this.affchFormBouteille = !this.affchFormBouteille
            if (!bouteilleSelectione) {
                bouteilleSelectione = {
                    source: 'saq',
                    cellier_id: localStorage.getItem('cellier_id'),
                }
            }
            bouteilleSelectione.quantite || (bouteilleSelectione.quantite = 1)
            bouteilleSelectione.garder_jusqu_a || (bouteilleSelectione.garder_jusqu_a = 2023)
            bouteilleSelectione.date_achat || (bouteilleSelectione.date_achat = new Date().toISOString().slice(0, 10))

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
        * @description cacher et afficher le formulaire pour archiver une bouteille
        */
        async togglerFormArchiverBouteille(bouteilleSelectione) {
            this.affchFormArchiverBouteille = !this.affchFormArchiverBouteille
            this.laBouteilleSelectione = bouteilleSelectione
        },


        /**
 * @author Hanane
 * @returns void
 * @description ajouter bouteille
 */
        async ajouterBouteille(donnees) {
            this.leChargement = true
            try {
                await axios.post('/api/contenir', donnees)
                this.togglerFormBouteille()
                await this.getBouteillesCellier(this.leCellierSelectione)

            } catch (error) {
                this.bouteilleErreurs = error.response.data.errors
            }
            this.leChargement = false

        },


        /**
* @author Hanane
* @returns void
* @description Modifier bouteille
*/
        async modifierBouteille(donnees, pasRafraichirCellier) {
            this.leChargement = true
            try {

                await axios.put(`/api/contenir/${donnees.id}`, donnees)
                if (!pasRafraichirCellier) await this.getBouteillesCellier(this.leCellierSelectione)
                this.affchFormBouteille = false
                this.togglerBouteilleAgerer(-1);

            } catch (error) {
                this.bouteilleErreurs = error.response.data.errors
            }

            this.leChargement = false

        },

        /**
* @author Hanane
* @returns void
* @description Supprimer bouteille
*/
        async supprimerBouteille() {
            this.leChargement = true
            try {

                await axios.delete(`/api/contenir/${this.laBouteilleSelectione.id}`)
                await this.getBouteillesCellier(this.leCellierSelectione)
                await this.togglerFormSupprimerBouteille()

            } catch (error) {
                this.bouteilleErreurs = error.response.data.errors
            }
            this.leChargement = false

        },

        /**
* @author Hanane
* @returns void
* @description Archiver bouteille
*/
        async archiverBouteille() {
            this.leChargement = true
            try {
                this.laBouteilleSelectione.quantite = 0
                await this.modifierBouteille(this.laBouteilleSelectione.id, false)
                await this.getBouteillesCellier(this.leCellierSelectione)
                await this.togglerFormArchiverBouteille()

            } catch (error) {
                this.bouteilleErreurs = error.response.data.errors
            }
            this.leChargement = false

        },


        /**
         * @author Saddek
         * @returns void
         * @description cacher et afficher le formulaire de cellier
         */
        async togglerFormCellier(nouveau) {
            this.cellierNouveau = nouveau
            this.afficherFormCellier = !this.afficherFormCellier
        },

        /**
         * @author Hanane
         * @returns void
         * @description retrouver la liste des celliers d'un usager connecté depuis le serveur
         */
        async getCelliers() {
            this.leChargement = true
            try {
                const donnees = await axios.get('/api/cellier')
                this.mesCelliers = donnees.data
                if (!localStorage.getItem('cellier_id')) {
                    localStorage.setItem('cellier_id', (this.mesCelliers[0] ? this.mesCelliers[0].id : -1))
                }
                this.leCellierSelectione = this.mesCelliers.filter(cel => cel.id == localStorage.getItem('cellier_id'))[0]

            } catch (error) {
                this.cellierErreurs = error.response.data.errors
            }
            this.leChargement = false
        },

        async gererCellier(donnees) {
            this.leChargement = true
            try {
                // Si l'usager veut supprimer un cellier
                if (!donnees) {
                    await axios.delete(`/api/cellier/${localStorage.getItem('cellier_id')}`)
                    localStorage.removeItem('cellier_id')
                    await this.getCelliers()
                    await this.getBouteillesCellier(this.leCellierSelectione)

                }
                // Si l'usager veut ajouter un cellier
                else if (this.cellierNouveau) {
                    const nouveauCellier = await axios.post(`/api/cellier`, {
                        nom: donnees.nom
                    })
                    localStorage.setItem('cellier_id', nouveauCellier.data.id)
                    await this.getCelliers()
                    this.togglerFormCellier()
                    await this.getBouteillesCellier(this.leCellierSelectione)

                    // Si l'usager veut modifier un cellier
                } else {
                    await axios.put(`/api/cellier/${donnees.id}`, {
                        nom: donnees.nom
                    })
                    localStorage.setItem('cellier_id', donnees.id)
                    await this.togglerFormCellier()

                }

            } catch (error) {
                this.cellierErreurs = error.response.data.errors
            }
            this.leChargement = false
        },

        /**
         * @author Hanane
         * @returns void
         * @description retrouver la liste des bouteilles de cellier d'un usager connecté depuis le serveur
         */
        async getBouteillesCellier(cellier, triPar) {
            this.leChargement = true
            this.mesBouteilleCellier = []
            const cellier_id = cellier ? cellier.id : localStorage.getItem('cellier_id')
            if (cellier_id == -1) return

            try {
                const donnees = await axios.get(`/api/cellier/${cellier_id}`, { params: { tri_par: triPar } })
                this.mesBouteilleCellier = donnees.data
                localStorage.setItem('cellier_id', cellier_id)
                cellier && (this.leCellierSelectione = cellier)

            } catch (error) {

                if (error.response.status == 404) {
                    this.mesBouteilleCellier = []
                } else {
                    this.mesBouteilleCellier = { 'erreur': 'un probléme' }
                }

            }
            this.leChargement = false
        },


        /**
 * @author Hanane
 * @returns void
 * @description retrouver la liste des bouteilles archivées d'un usager connecté depuis le serveur
 */
        async getBouteillesArchive(triPar) {
            this.leChargement = true
            this.mesBouteilleCellier = []

            try {
                const donnees = await axios.get(`/api/archive`, { params: { tri_par: triPar } })
                this.mesBouteilleCellier = donnees.data

            } catch (error) {

                if (error.response.status == 404) {
                    this.mesBouteilleCellier = []
                } else {
                    this.mesBouteilleCellier = { 'erreur': 'un problème' }
                }

            }
            this.leChargement = false
        },


        /**
         * @author Saddek
         * @returns void
         * @description retrouver la liste des bouteilles par filtre
         */
        async getBouteillesFiltre(donnes) {
            this.leChargement = true
            donnes.cellier_id = this.leCellierSelectione.id
            this.mesBouteilleCellier = []

            try {
                donnes.filtre = 'oui'
                const donnees = await axios.get(`/api/contenir`, { params: donnes })
                this.mesBouteilleCellier = donnees.data

            } catch (error) {

                if (error.response.status == 404) {
                    this.mesBouteilleCellier = []
                } else {
                    this.mesBouteilleCellier = { 'erreur': 'un problème' }
                }

            }
            this.leChargement = false
        },

        /**
         * @author Saddek
         * @returns void
         * @description retrouver la liste des bouteille d'un usager connecté depuis le serveur
         */
        async rechercherBouteilles(motCle, triPar) {
            this.leChargement = true

            this.mesResultatDeRechercheBouteille = []
            try {
                const donnees = await axios.get(`/api/contenir`, { params: { recherche: 'oui', mot_cle: motCle, tri_par: triPar } })
                this.mesResultatDeRechercheBouteille = donnees.data
            } catch (error) {

                if (error.response.status == 404) {
                    this.mesResultatDeRechercheBouteille = []
                }

            }
            this.leChargement = false
        },

    },

})