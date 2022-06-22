<script lang="ts">
import { defineComponent } from 'vue';
import ApiData from '@/components/ApiData.vue';

export default defineComponent ({
    components: { ApiData },
});
</script>

<template>
<div class="row">
    <div class="col-s12">
        <a class="waves-effect waves-light btn"><i class="material-icons left">cloud</i>button</a>
    </div>
</div>
</template>

<style lang="scss">
@import '@/assets/views.scss';
</style>
