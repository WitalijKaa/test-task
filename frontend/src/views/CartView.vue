<script lang="ts">
import { defineComponent } from 'vue';
import Cart from '@/components/Cart.vue';

export default defineComponent ({
    components: { Cart },
});
</script>

<template lang="pug">
div.row
  div.col-s12
    h1 Cart
    cart
</template>

<style lang="scss">
@import '@/assets/views.scss';
</style>
