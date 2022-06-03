<script lang="ts">
import axios from 'axios';
import { defineComponent } from 'vue'
import { mapState } from 'pinia'
import { useCurrencyStore } from '@/stores/currencyStore';
import Item from '@/models/Item';
import * as CONF from '@/models/conf';
import Group from '@/models/Group';

type GroupsType = {[key: string]: Group}

export default defineComponent({
    data() { return {
        apiItems: [],
        apiGroups: [],
    }},
    mounted() {
        Item.implementGroupsProvider({
            getNameByItemID: this.getNameByItemID
        });

        axios.get('http://tt.loc/api/v1/data/1/data.json')
            .then((response) => {
                    this.apiItems = response.data.Value.Goods;
                });
        axios.get('http://tt.loc/api/v1/data/1/names.json')
            .then((response) => {
                console.log(response.data)
                    this.apiGroups = response.data;
                });
    },
    computed: {
        ...mapState(useCurrencyStore, ['converter']),
        modelsItems() : Array<Item> {
            return this.apiItems.map((data) => {
                const model = new Item(data[CONF.K_ITEM_ID], data[CONF.K_GROUP_ID], this.converter);
                model.amount = data[CONF.K_AMOUNT];
                model.priceUSD = data[CONF.K_PRICE_UDS];
                return model;
            })
        },
        modelsGroups() : GroupsType {
            let models: GroupsType = {};
            for (let groupID in this.apiGroups) {
                const model = new Group(groupID, this.apiGroups[groupID][CONF.K_GROUP_NAME]);

                for (let itemID in this.apiGroups[groupID][CONF.K_ITEMS_IN_GROUP]) {
                    const apiItem = this.apiGroups[groupID][CONF.K_ITEMS_IN_GROUP][itemID];
                    model.addItem(itemID, apiItem[CONF.K_ITEM_NAME]);
                }
                models[groupID] = model;
            }
            return models;
        },
        itemsNames() : Array<string> {
            return this.modelsItems.map(model => model.name + ' ' + model.priceRUB);
        }
    },
    methods: {
        getNameByItemID(itemID: string, groupID: string) : string | undefined {
            if (this.modelsGroups[groupID]) {
                return this.modelsGroups[groupID].getItemByID(itemID);
            }
        }
    }
})
</script>

<template lang="pug">
div
    pre {{itemsNames}}
</template>

<style scoped>
</style>
