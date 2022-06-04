# test-task

in /frontend readme there is a task

## deploy

composer install

mount /public to http://tt.loc/

http://tt.loc/api/v1/currency
http://tt.loc/api/v1/data/1/data.json
http://tt.loc/api/v1/data/1/names.json

goto /frontend

npm install
npm run dev

## comments

all api communication and storing data goes throw the /frontend/src/stores

viewing data and cart goes throw the /frontend/src/components

data items is represented in models

to handle mess in api data there is a conf.ts

components should be separated to small view items, but I think it's very obvious and very easy
