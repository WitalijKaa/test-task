export default class Group {

    private items: {[key: string]: string} = {}

    constructor(public readonly id: string, public readonly name: string) { }

    public addItem(id: string, name: string) {
        this.items[id] = name;
    }

    public getItemByID(id: string) : string | undefined {
        return this.items[id];
    }
}