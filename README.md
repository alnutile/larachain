# LaraChain

## Reading over LangChain

And just thinking how to make some of those flows work in a Laravel environment

[https://github.com/hwchase17/langchain](https://github.com/hwchase17/langchain)

## Setup
Follow the Sail Laravel docs eg `sail up`

Seed the user:

Update your `.env` file:

```dotenv
ADMIN_EMAIL=foo@bar.com
ADMIN_PASSWORD=foobaz
```

```bash
sail artisan migrate
sail artisan db:seed --class=UserSeeder
```

## TODO
  * Embedding flow with vector 
  * UI to easily take in data to embed
  * a 💩load more
