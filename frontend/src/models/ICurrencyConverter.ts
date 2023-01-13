export interface ICurrencyConverter {
    usdToRub : (usdPrice: number) => number;
    eurToRub : (eurPrice: number) => number;
}