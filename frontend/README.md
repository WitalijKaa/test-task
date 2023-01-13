# test-task I == ugly format

tags: VueJS frontend architecture

Show data.json nice, where

"C" - price USD - transform it to rubles.
"G" - id of group.
"T" - id of good.
"P" - items left.

Once per 15 seconds currency rates changes. Put colors if rubles-cost is higher or lower. Create shop-cart.

## deploy

composer install

mount /public to http://localhost:3000/

it will just create an api

http://localhost:3000/api/v1/currency
http://localhost:3000/api/v1/data/1/data.json
http://localhost:3000/api/v1/data/1/names.json

goto /frontend

npm install
npm run dev

## comments

all api communication and storing data goes throw the /frontend/src/stores

viewing data and cart goes throw the /frontend/src/components

data items is represented in models

to handle mess in api data there is a conf.ts

components should be separated to small view items, but I think it's very obvious and very easy

# original-task-text of the task I dont like

Получить данные из файла data.json и вывести их на страницу как это показано на рис."пример.png".

Показанные на рисунке параметры находятся в узле Goods. 
"C" - цена в долларах(USD) - вывести в рублях(курс выбрать произвольно), 
"G" - id группы, 
"T" - id товара, 
"P" - сколько единиц товара осталось (параметр, который указан в скобках в названии).

Сопоставления id групп и товаров с их названиями находятся в файле names.json.

После вывода данных навесить обработчики для добавления выбранного товара в корзину и удаления из нее.
Пример корзины показан в файле "Корзина.png". Сделать рассчет общей суммы товаров и вывести отдельным полем.
Корзина находится на одной и той же странице вместе со списком товаров.

Вывести данные используя привязку к представлению и возможностью последующего изменения (two-way binding).
Можно использовать фреймворки. 
Сделать обновление цены товара в зависимости от курса валюты.
С интервалом в 15 секунд читать исходный файл data.json и одновременно менять курс доллара (вручную) на значение от 20 до 80,
выполняя обновление данных в модели (с изменением в представлении).

Если цена увеличилось в большую сторону - подсветить ячейку красным, если в меньшую - зеленым.

Дополнительная информация: Дизайну, показанному в примерах, следовать не обязательно.
Прокомментировать основные действия. Интересные решения приветствуются.
