export default class Item {

    public visibleId: number = 0;
    public recordId: number = 0;
    public _recordData: number = 0;
    public doc_path: string = '';

    constructor(public readonly id: number) { }

    public get recordData() : number {
        return this._recordData;
    }
    public set recordData(val: number) {
        this._recordData = val;
    }
}
