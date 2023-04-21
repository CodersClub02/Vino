<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '../stores/auth'

const authStore = useAuthStore()

let modifier = ref(false)
function toggleModifier() {
    this.modifier = !this.modifier
}

const form = ref({
    nom: '',
    courriel: '',
    mot_de_passe: '',
    confirmer_mot_de_passe: ''
});

onMounted(async () => {
    await authStore.getUser()
    form.value.nom = authStore.user.name;
    form.value.courriel = authStore.user.email;
    form.value.mot_de_passe = authStore.user.password;
})
</script>

<template>
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl tracking-tight text-gray-900">Salut <span class="font-bold text-orange-400">{{ authStore.user.name }}</span></h1>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Mon compte</h2>
                </div>

                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form class="space-y-6">

                        <div>
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nom</label>
                            <div class="mt-2">
                                <input id="name" name="nom" :disabled="!modifier" v-model="form.nom" type="text"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="authStore.erreurs.name" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.name[0] }}</span>

                            </div>
                        </div>


                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Courriel</label>
                            <div class="mt-2">
                                <input id="email" name="courriel" :disabled="!modifier" v-model="form.courriel" type="email"
                                    autocomplete="email"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="authStore.erreurs.email" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.email[0] }}</span>

                            </div>
                        </div>


                        <div v-if="modifier">
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Mot de
                                    Passe</label>
                            </div>
                            <div class="mt-2">
                                <input id="password" name="mot_de_passe" :disabled="!modifier" v-model="form.mot_de_passe"
                                    type="password"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="authStore.erreurs.password" class="mt-2">
                                <span class="text-red-400 text-sm m-2 p-2">{{ authStore.erreurs.password[0] }}</span>

                            </div>
                        </div>

                        <div v-if="modifier">

                            <div class="flex items-center justify-between">
                                <label for="passwordConfirm"
                                    class="block text-sm font-medium leading-6 text-gray-900">Confirmez votre mot de
                                    Passe</label>
                                <div class="text-sm">
                                </div>
                            </div>
                            <div class="mt-2">
                                <input id="passwordConfirm" name="confirmer_mot_de_Passe"
                                    v-model="form.confirmer_mot_de_passe" type="password"
                                    class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6" />
                            </div>
                        </div>

                        <div v-if="modifier">
                            <button type="submit"
                                class="flex w-full justify-center rounded-md bg-rose-800 px-3 p-3 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-rose-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-800">Sauvegarder</button>

                        </div>

                        <div v-else>
                            <button type="button" @click="toggleModifier()"
                                class="flex w-full justify-center rounded-md bg-rose-800 px-3 p-3 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-rose-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-800">Modifier</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>
</template>