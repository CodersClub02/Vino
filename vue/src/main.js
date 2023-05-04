/**
 * @author Saddek
 * Fichier principal de l'application vue
 * @description import et lance les objet/fonction/vue: App, pinia, router...
 *              et finalement mount l'application sur l'element #app
 */

/** pour créer l'application vue, et injecter un object dans l'appli vuejs */
import { createApp, markRaw } from 'vue'

/** pour le stockage des données et état de données */
import { createPinia } from 'pinia'

/** pour tous ce qui est routage */
import router from './router'

/** pour interoger le serveur */
import './axios'

/** importation de tous ce qui est style Tailwind
 *  durant tout le projet on essaye de ne pas utiliser des styles css dans
 *  les composantes vue
 */
import './style.css'


/** */
import App from './App.vue'

/** creation d'objet store pour injection de l'objet router a fin qu'il soit
 * disponible et accessible partout dans l'application vue
 * 
 */
const pinia = createPinia()
pinia.use(({ store }) => {
    store.router = markRaw(router)
})

/* importer  fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* importer le composant font awesome icon  */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'


import { faUserSecret, faUser, faRightFromBracket, faUserPlus, faTrash, faPenToSquare, faCirclePlus, faEye } from '@fortawesome/free-solid-svg-icons'

/* ajouter icônes à la bibliothèque */
library.add(faUserSecret, faUser, faRightFromBracket, faUserPlus, faTrash, faPenToSquare, faCirclePlus, faEye)


/** création et initialisation de l'objet app vuejs */
const app = createApp(App).component('font-awesome-icon', FontAwesomeIcon)
app.use(pinia)
app.use(router)
app.mount('#app')