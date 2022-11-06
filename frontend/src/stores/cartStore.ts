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
      getAmountByID() {
          return (itemID: string) : number => {
              let amount = 0;
              for (const itemsKey in this.items) {
                  if (itemID == this.items[itemsKey].id) {
                      return this.items[itemsKey].amount;
                  }
              }
              return amount;
          }
      },
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
