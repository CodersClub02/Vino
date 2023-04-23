<script setup>
/**
 * @author Saddek
 * @description Vue de navigation principale de l'application
 */

import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItems } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'

import { useAuthStore } from "../stores/auth";
const authUsager = useAuthStore();


</script>

<template>
  <div class="min-h-full">
    <Disclosure as="nav" class="bg-black" v-slot="{ open }">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <router-link :to="{ name: 'Accueil' }">
                <img class="h-14" src="vino-logo.png" alt="Vino" />
              </router-link>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">

              <!-- Profile dropdown -->
              <Menu as="div" class="relative ml-3" v-if="authUsager.user">
                <div>
                  <MenuButton
                    class="flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                    <span class="sr-only">Ouvrir le menu</span>
                    <img class="h-8 w-8 rounded-full" src="profil.png" alt="profil" />
                  </MenuButton>
                </div>
                <transition enter-active-class="transition ease-out duration-100"
                  enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                  leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
                  leave-to-class="transform opacity-0 scale-95">
                  <MenuItems
                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <router-link :to="{ name: 'Profil' }"
                      :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Mon
                      Profil</router-link>


                    <button @click="authUsager.deconnecter()"
                      class="block px-4 py-2 text-sm text-gray-700">Déconnecter</button>
                  </MenuItems>
                </transition>
              </Menu>

              <div class="-mr-2 flex space-x-2" v-else>
                <!-- desktop menu button -->
                <router-link :to="{ name: 'CreerCompte' }" class="inline-flex items-center justify-center rounded-md p-2 text-white
              hover:text-rose-400">S'inscrire</router-link>
              </div>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden" v-if="authUsager.user">
            <!-- Mobile menu button -->
            <DisclosureButton
              class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
              <span class="sr-only">Open main menu</span>
              <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
              <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
            </DisclosureButton>
          </div>
          <div class="-mr-2 flex md:hidden space-x-2" v-else>
            <!-- Mobile menu button -->
            <router-link :to="{ name: 'CreerCompte' }" class="inline-flex items-center justify-center rounded-md p-2 text-white
              hover:text-rose-400">S'inscrire</router-link>
          </div>
        </div>
      </div>

      <DisclosurePanel class="md:hidden" v-if="authUsager.user">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
          <router-link :to="{ name: 'Accueil' }"
            :class="[false ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
            :aria-current="false ? 'page' : undefined">Accueil</router-link>
        </div>
        <div class="border-t border-gray-700 pb-3 pt-4">
          <div class="flex items-center px-5">

            <div class="flex-shrink-0">
              <img class="h-10 w-10 rounded-full" src="profil.png" alt="profil" />
            </div>
            <div class="ml-3">
              <div class="text-base font-medium leading-none text-white">
                <router-link :to="{ name: 'Profil' }">{{ authUsager.user.name }}</router-link>

              </div>
            </div>

          </div>

          <div class="mt-3 px-2 flex justify-between">
            <router-link :to="{ name: 'Profil' }"
              class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Profil</router-link>
            <button @click="authUsager.deconnecter()"
              class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Déconnecter</button>
          </div>

        </div>

      </DisclosurePanel>
  </Disclosure>
</div>
</template>