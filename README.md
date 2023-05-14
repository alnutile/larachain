# LaraChain

## Reading over LangChain

[LaraChain.io](https://github.com/alnutile/larachain/wiki)

And just thinking how to make some of those flows work in a Laravel environment

[![LaraChain Full Demo](https://img.youtube.com/vi/cz7d6d3pk4o/0.jpg)](https://www.youtube.com/watch?v=cz7d6d3pk4o)


## Links

The PHP Vector library

https://github.com/pgvector/pgvector-php

## Setup

> Make sure to have .env in place before running `sail up`

Follow the Sail Laravel docs eg `sail up` for Postgres only the rest is just 
normal Laravel. The brew install did not work on my M2

Seed the user:

Update your `.env` file:

```dotenv
ADMIN_EMAIL=foo@bar.com
ADMIN_PASSWORD=foobaz
```

This just helps since Jetstream requires a team etc to work.


```bash
sail artisan migrate
sail artisan db:seed --class=UserSeeder
```


## Migration Note

```php 
$table->integer('token_count');
$table->vector('embedding', 1536)->nullable(); 
```

## More Logging 

```bash 
php artisan feature:on database larachain_logging
```



