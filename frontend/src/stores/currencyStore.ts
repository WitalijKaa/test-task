import type { ICurrencyConverter } from '@/models/ICurrencyConverter';
import { defineStore } from 'pinia'

export const useCurrencyStore = defineStore({
  id: 'currencyStore',
  state: () => ({
    usd: 65,
    eur: 80,
    old: {
      usd: 65,
      eur: 80,
    }
  }),
  getters: {
    converter: (state) : ICurrencyConverter => {
      return {
        usdToRub: (usdPrice: number) : number => { return usdPrice * state.usd; },
        eurToRub: (eurPrice: number) : number => { return eurPrice * state.eur; },
      };
    },
    isUsdRised: (state) : boolean => {
      return state.usd > state.old.usd;
    },
    isEurRised: (state) : boolean => {
      return state.usd > state.old.usd;
    },
  },
  actions: {
    setCurrency(currency: 'usd' | 'eur', value: number) {
      if (!value) { return; }
      this.old[currency] = this[currency];
      this[currency] = value;
    },
  },
})
