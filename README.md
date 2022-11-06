# test-task I == ugly format

###tags: VueJS frontend architecture

Show data.json nice, where

https://github.com/WitalijKaa/test-task/blob/task_1/resources/data/1/data.json

"C" - price USD - transform it to rubles.
"G" - id of group.
"T" - id of good.
"P" - items left.

Once per 15 seconds currency rates changes. Put colors if rubles-cost is higher or lower than previous. Create shop-cart.

## deploy

composer install

mount /public to http://tt.loc/

it will just create an api

- http://tt.loc/api/v1/currency
- http://tt.loc/api/v1/data/1/data.json
- http://tt.loc/api/v1/data/1/names.json

goto /frontend

npm install

npm run dev

## comments

all api communication and storing data goes throw the /frontend/src/stores

viewing data and cart goes throw the /frontend/src/components

data items is represented in models

to handle mess in api data there is a conf.ts

components should be separated to small view items, but I think it's very obvious and very easy
