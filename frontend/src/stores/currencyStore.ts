import type { ICurrencyConverter } from '@/models/ICurrencyConverter';
import { defineStore } from 'pinia'

export const useCurrencyStore = defineStore({
  id: 'currencyStore',
  state: () => ({
    usd: 65,
    eur: 80,
  }),
  getters: {
    converter: (state) : ICurrencyConverter => {
      return {
        usdToRub: (usdPrice: number) : number => { return usdPrice * state.usd; },
        eurToRub: (eurPrice: number) : number => { return eurPrice * state.eur; },
      };
    }
  },
})
