<script lang="ts">
import { defineComponent } from 'vue'
import { useDataStore } from '@/stores/dataStore';
import { mapStores, mapState, mapActions } from 'pinia';

export default defineComponent({
    computed: {
        ...mapStores(useDataStore),
        ...mapState(useDataStore, ['modelsItems', 'apiItems']),
    },
    mounted() {
        this.getDataByApi();
    },
    methods: {
        ...mapActions(useDataStore, ['getDataByApi']),
        editDataRowOnClick(id) {
            this.$emit('editRecord', id)
        },
        deleteDataRowOnClick(ix) {
            this.apiItems.splice(ix, 1)
        },
    }
})
</script>

<template>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th @click="editDataRowOnClick()">Settings</th>
            <th>Edit record</th>
            <th>Delete record</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(record, ix) in modelsItems">
            <td class="row-data">{{ record.id + 1 }}</td>
            <td class="row-data">{{ record.doc_path }}</td>
            <td><button @click="editDataRowOnClick(record.id)">edit</button></td>
            <td><button @click="deleteDataRowOnClick(ix)">delete</button></td>
        </tr>
        </tbody>
    </table>
</template>

<style scoped>
</style>
