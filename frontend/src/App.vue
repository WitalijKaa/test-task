<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'

import { getCurrencies } from '@/composables/currencies';
import { useCurrencyStore } from '@/stores/currencyStore';
import Item from './models/Item';
import { useDataStore } from '@/stores/dataStore';

getCurrencies();
Item.implementCurrencyConverter(useCurrencyStore().converter);

const dataStore = useDataStore();
dataStore.getDataByApi();
Item.implementGroupsProvider({
    getNameByItemID: dataStore.getNameByItemID
});
</script>

<template lang="pug">
div.container
  nav
    div.nav-wrapper
      ul.right.hide-on-med-and-down
        li
          RouterLink(to="/") Store
        li
          RouterLink(to="/cart") Cart
  RouterView
</template>

<style>
@import '@/assets/base.css';

</style>
