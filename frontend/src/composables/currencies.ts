import axios from 'axios';
import { onBeforeMount } from 'vue'
import { useCurrencyStore } from '@/stores/currencyStore';
import { RENEW_CURRENCY_RATE_MS } from '@/models/conf';

export function getCurrencies() {
  onBeforeMount(() => {
    function renewCurrencies() {
      axios.get('http://tt.loc/api/v1/currency')
      .then((response) => {
              if (!response.data) { return; }
              const currencyStore = useCurrencyStore();
              currencyStore.setCurrency('usd', response.data.usd);
              currencyStore.setCurrency('eur', response.data.eur);
          })
    }

    renewCurrencies();
    setInterval(renewCurrencies, RENEW_CURRENCY_RATE_MS);
  })
}