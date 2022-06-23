<template>
    <div>
        <span class="addon span-modalbox">Record #</span><input class="smooth" id="m-edit-record" type="text">
        <br><br>
        <span class="addon span-modalbox">Settings</span><input class="smooth" id="m-edit-settings" type="text">
        <br><br>
        <input type="file">
        <input type="file" name="BrowseFolder" size=50>
        <br><br><br>
        <a class="btn-sm btn-a" @change=modalBoxEditBtnSave>Save</a>
        <a class="btn-sm btn-c" @change=modalBoxEditBtnCancel()>Cancel</a>
    </div>
</template>

<script>
import {mapActions} from "pinia";
import {useDataStore} from "@/stores/dataStore";

export default {
    name: "Modal",
    methods: {
        modalBoxEditBtnSave() {
        },
        modalBoxEditBtnCancel(ev) {
        },
    }
}
</script>

<style scoped>

</style>
