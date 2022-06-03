import Item from '@/models/Item';
import Group from '@/models/Group';
import { defineStore } from 'pinia';
import * as CONF from '@/models/conf';
import axios from 'axios';

export type GroupsType = {[key: string]: Group}

export const useDataStore = defineStore({
  id: 'dataStore',
  state: () => ({
    apiItems: [],
    apiGroups: [],
  }),
  getters: {
    modelsItems: (state) : Array<Item> => {
        return state.apiItems.map((data) => {
            const model = new Item(data[CONF.K_ITEM_ID], data[CONF.K_GROUP_ID]);
            model.amount = data[CONF.K_AMOUNT];
            model.priceUSD = data[CONF.K_PRICE_UDS];
            return model;
        })
    },
    modelsGroups: (state) : GroupsType => {
        let models: GroupsType = {};
        for (let groupID in state.apiGroups) {
            const model = new Group(groupID, state.apiGroups[groupID][CONF.K_GROUP_NAME]);

            for (let itemID in state.apiGroups[groupID][CONF.K_ITEMS_IN_GROUP]) {
                const apiItem = state.apiGroups[groupID][CONF.K_ITEMS_IN_GROUP][itemID];
                model.addItem(itemID, apiItem[CONF.K_ITEM_NAME]);
            }
            models[groupID] = model;
        }
        return models;
    },
    getNameByItemID() {
        return (itemID: string, groupID: string) : string | undefined => {
            if (this.modelsGroups[groupID]) {
                return this.modelsGroups[groupID].getItemByID(itemID);
            }
        }
    },
    isAnyItemInGroup() {
        return (groupID: string) => {
            let isAny = false;
            this.modelsItems.map((item) => {
                if (item.groupID == groupID) { isAny = true; }
            })
            return isAny;
        }
    },
  },
  actions: {
    getDataByApi() {
        axios.get('http://tt.loc/api/v1/data/1/data.json')
        .then((response) => {
                this.apiItems = response.data.Value.Goods;
            });
        axios.get('http://tt.loc/api/v1/data/1/names.json')
            .then((response) => {
                    this.apiGroups = response.data;
                });
    },
  },
})
