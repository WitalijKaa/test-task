<script lang="ts">
import { defineComponent, nextTick } from 'vue'
import { useCurrencyStore } from '@/stores/currencyStore';
import { useDataStore } from '@/stores/dataStore';
import { useCartStore } from '@/stores/cartStore';

export default defineComponent({
    setup () {
        const storeCurrency = useCurrencyStore()
        const storeData = useDataStore()
        const storeCart = useCartStore()
        return { storeCurrency, storeData, storeCart }
    },
    mounted() {
        nextTick(() => {
            setTimeout(() => {
                var elems = document.querySelectorAll('.collapsible');
                // @ts-ignore
                var instances = M.Collapsible.init(elems, {});
            }, 500)
        });
    },
    methods: {
        buyItem(id: string) {
            this.storeCart.buyItem(id);
        }
    }
})
</script>

<template lang="pug">
ul.collapsible
  li(v-for="(group, k, ix) in storeData.modelsGroups" :key="group.id" :class="{ active: !ix }")
    div.collapsible-header
      i.material-icons whatshot
      span {{group.name}}
    div.collapsible-body
      span(v-if="!storeData.isAnyItemInGroup(group.id)") Здесь типа пусто
      span(v-else v-for="item in storeData.modelsItems")
        template(v-if="item.groupID == group.id" :key="item.id")
          div.card.blue-grey.darken-1
            div.card-content.white-text
              span.card-title {{item.name}}
              p Товар ## {{item.id}}
            div.card-action
              a(href="#" @click.prevent) осталось {{item.amount}}
              a(href="#" @click.prevent :class="[storeCurrency.isUsdRised ? 'red-text' : 'green-text']") цена {{item.priceRUB}} ₽
              a(href="#" @click.prevent="buyItem(item.id)") купить
</template>

<style scoped>
</style>
