import Item from '@/models/Item';
import { defineStore } from 'pinia';
import axios from 'axios';

export const useDataStore = defineStore({
  id: 'dataStore',
  state: () => ({
    apiItems: [] as Array<Item>,
  }),
  getters: {
    modelsItems: (state) : Array<Item> => {
        return state.apiItems;
    },
    getItemModelByID() {
        return (itemID: number) : Item | undefined => {
            let returnModel = undefined;
            this.modelsItems.map((model) => {
                if (model.id == itemID) {
                    returnModel = model;
                }
            })
            return returnModel;
        }
    },
  },
  actions: {
    getDataByApi() {

        for (let ix = 1; ix < 11; ix++) {
            this.apiItems.push(new Item(ix));
        }

        // axios.get('http://tt.loc/api/v1/data/1/data.json')
        //     .then((response) => {
        //         this.apiItems = response.data.some_field;
        //     });
    },
  },
})
