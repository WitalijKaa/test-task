# test-task IV == very secret code

- architecture
- Laravel
- PHP
- SOLID
- backend
- OOP

This is example of complex staff in one of my commercial project.

I guess I can provide some little code examples with comments.

## comments

Look at RecipeController. It exists only to provide rules. If we dont want that some table from DB has validation rules, we can just create model like Recipe... and we will be able to use standard CRUD requests.

All because of class AnyController and function listByHttpQuery. Pics 20 and 22 shows the result of GET request using filters.

Look at RecipeStepController. It has mass-update method. We can use it to resort some collection of BelogsTo models with validation like in class SameForeignKey (without providing the key).

We can add methods like function createRequiredAttributes for models, to fill required field on POST request with sensitive data.

We are able to create functions like function embedActiveToBuilder to provide DB search by aggregated fields.

All filters are implemented in class HttpQueryFilter. Table relations are used in trait BuilderByHttpQueryTrait.

This is very powerful functionality. You can request available DB data using simple SQL queries. It covers 95% of tasks, making development economy for 75% and high bug resist for system.

And main thing: all complex become easy. Just look at this thin controllers.
