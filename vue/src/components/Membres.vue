<script setup>
import { ref, onMounted } from 'vue';
import Input from './Input.vue';
import Button from './Button.vue';
import SecButton from './SecButton.vue';
import { useAdminStore } from '../stores/admin'


const adminStore = useAdminStore()
onMounted(async () => {
    await adminStore.getMembres()

})
</script>

<template>
    <table>
        <tr>
            <th>Nom</th>
            <th>Courriel</th>
            <th>Date d'iscription</th>
            <th>Celliers</th>
            <th>Bouteilles</th>
            <th>Actif</th>
        </tr>
        <tr v-for="membre in adminStore.listeMembres">
            <td>{{ membre.name }}</td>
            <td>{{ membre.email }}</td>
            <td>{{ membre.created_at }}</td>
            <td>{{ membre.celliers_count }}</td>
            <td>{{ membre.contenirs_count }}</td>
            <td>{{ membre.actif }}</td>
        </tr>

    </table>
</template>