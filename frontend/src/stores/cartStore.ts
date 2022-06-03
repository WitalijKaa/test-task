import type Item from '@/models/Item';
import { defineStore } from 'pinia';
import * as CONF from '@/models/conf';
import { useDataStore } from '@/stores/dataStore';

export type ItemsType = {[key: string]: Item}

export const useCartStore = defineStore({
  id: 'cartStore',
  state: () => ({
    items: {} as ItemsType,
  }),
  getters: {
    
  },
  actions: {
    buyItem(id: string, amount: number = 1) {
        if (amount < 1) { return;}

        const dataModel = useDataStore().getItemModelByID(id);
        if (dataModel) {
            if (!this.items[id]) {
                this.items[id] = dataModel.clone;
            }

            if (this.items[id].amount < dataModel.amount) {
                this.items[id].amount += amount;
            }
        }
    },
  },
})
