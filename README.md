# online store where we use ugly json format

#### https://test1.magic-stone-circuit.app/

## test-task 1

- VueJS
- TypeScript
- Pug
- MaterializeCss
- frontend
- architecture

### use VueJS, TypeScript, Docker, Laravel

### Show data.json nice

https://github.com/WitalijKaa/test-task/blob/task_1_2/resources/data/1/data.json

- "C" - price USD - transform it to rubles.
- "G" - id of group.
- "T" - id of good.
- "P" - items left.
- Once per 15 seconds currency rates changes. Put colors if rubles-cost is higher or lower than previous. Create shop-cart.

## to make it work:

# docker-compose up -d

## http://localhost/

#### http://localhost:3000/api/v1/data/1/data.json

#### http://localhost:3000/api/v1/data/1/names.json

---
The demo here https://test1.magic-stone-circuit.app/

## comments

all api communication and storing data goes throw the /frontend/src/stores

viewing data and cart goes throw the /frontend/src/components

data items is represented in models

to handle mess in api data there is a conf.ts

components should be separated to small view items, but I think it's very obvious and very easy (for time spending)
