<script lang="ts">
import { defineComponent } from 'vue';
import ApiData from '@/components/ApiData.vue';

export default defineComponent ({
    components: { ApiData },
});
</script>

<template lang="pug">
div(class='some-page')
    div
        h1 Web-store
        ApiData
</template>

<style lang="scss">
@import '@/assets/views.scss';
</style>
