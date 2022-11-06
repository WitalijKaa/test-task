<script lang="ts">
import { defineComponent } from 'vue'
import { useCartStore } from '@/stores/cartStore';

export default defineComponent({
    setup () {
        const storeCart = useCartStore()
        return { storeCart }
    },
})
</script>

<template lang="pug">
ul.collection
  li.collection-item.avatar(v-for="item in storeCart.items")
    i.material-icons.circle.green insert_chart
    span.title {{item.name}}
    p amount {{item.amount}}
      br
      | full price {{item.amount * item.priceRUB}}
    a.secondary-content(href="#" @click.prevent)
      i.material-icons delete_outline
      a.secondary-content(href="#" @click.prevent)
      i.material-icons.pusle add_shopping_cart
</template>

<style scoped>
</style>
