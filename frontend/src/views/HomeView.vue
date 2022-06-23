<script lang="ts">
import { defineComponent } from 'vue';
import ApiData from '@/components/ApiData.vue';
import Modal from '@/components/Modal.vue';

export default defineComponent ({
    data () { return{
        isModal: false as boolean,
    }},
    components: { ApiData, Modal },
    methods: {
        editRecordInModal(id) {
            console.log(id);
            this.isModal = true;
        }
    }
});
</script>

<template>
<!-- Main scope -->
<div class="default-padding">
    <h2 class="bottom-border">General settings</h2>

    <!-- API section -->
    <div>
        <span class="addon">API KEY</span><input class="smooth" id="api_key" type="text">
        <label for="api_key">(your API key)</label>
        <a class="btn-sm btn-b">Apply</a>
    </div>

    <!-- Settings table -->
    <h3 class="bottom-border">data to sync</h3>

    <a class="btn-sm btn-b">Add</a><br><br>

    <ApiData v-on:editRecord="editRecordInModal"></ApiData>
    <Modal v-show="isModal"></Modal>
</div>
</template>
