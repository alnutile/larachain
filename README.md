# LaraChain

## Reading over LangChain

And just thinking how to make some of those flows work in a Laravel environment

[https://github.com/hwchase17/langchain](https://github.com/hwchase17/langchain)


> I am still researching terminology and patterns used by LangChain 
> will update below once I get more info and make the plugin system clear 
> which will just use composer to plugin actions etc

![image](https://user-images.githubusercontent.com/365385/233626512-7611da42-5d89-4b1e-84a6-8a8cdaa38f9e.png)


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


## Migration Note

```php 
$table->integer('token_count');
$table->vector('embedding', 1536)->nullable(); 
```
