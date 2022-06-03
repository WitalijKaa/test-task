import type { ICurrencyConverter } from "./ICurrencyConverter";

export type GroupsProvider = {
    getNameByItemID: (itemID: string, groupID: string) => string | undefined
}

export default class Item {

    public amount: number = 0;
    private itemPriceUSD: number = 0;

    private static converter: ICurrencyConverter;
    private static groupsProvider: GroupsProvider;

    constructor(private readonly id: string, private readonly groupID: string) { }

    public get name() : string | undefined {
        return Item.groupsProvider.getNameByItemID(this.id, this.groupID);
    }

    public set priceUSD(price: number) {
        this.itemPriceUSD = price;
    }

    public get priceRUB() : number {
        return Item.converter.usdToRub(this.itemPriceUSD);
    }
    public get priceUSD() : number {
        return this.itemPriceUSD;
    }

    public static implementGroupsProvider(provider: GroupsProvider) {
        if (!Item.groupsProvider) {
            Item.groupsProvider = provider;
        }
    }

    public static implementCurrencyConverter(converter: ICurrencyConverter) {
        if (!Item.converter) {
            Item.converter = converter;
        }
    }
}