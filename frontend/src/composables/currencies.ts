import axios from 'axios';
import { onBeforeMount } from 'vue'
import { useCurrencyStore } from '@/stores/currencyStore';

export function getCurrencies() {
  onBeforeMount(() => {
    axios.get('http://tt.loc/api/v1/currency')
      .then((response) => {
              const currencyStore = useCurrencyStore();
              currencyStore.usd = response.data.usd ? response.data.usd : currencyStore.usd;
              currencyStore.eur = response.data.eur ? response.data.eur : currencyStore.eur;

              console.log(currencyStore.usd, response.data.usd, '!!')
          })

  })
}