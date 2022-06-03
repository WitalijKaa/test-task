import axios from 'axios';
import { onBeforeMount } from 'vue'
import { useCurrencyStore } from '@/stores/currencyStore';
import { RENEW_CURRENCY_RATE_MS } from '@/models/conf';

export function getCurrencies() {
  onBeforeMount(() => {
    function renewCurrencies() {
      axios.get('http://tt.loc/api/v1/currency')
      .then((response) => {
              const currencyStore = useCurrencyStore();
              currencyStore.usd = response.data.usd ? response.data.usd : currencyStore.usd;
              currencyStore.eur = response.data.eur ? response.data.eur : currencyStore.eur;
          })
    }

    renewCurrencies();
    setInterval(renewCurrencies, RENEW_CURRENCY_RATE_MS);
  })
}