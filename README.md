# LaraChain

## Reading over LangChain

And just thinking how to make some of those flows work in a Laravel environment

[https://github.com/hwchase17/langchain](https://github.com/hwchase17/langchain)


> I am still researching terminology and patterns used by LangChain 
> will update below once I get more info and make the plugin system clear 
> which will just use composer to plugin actions etc

![image](https://user-images.githubusercontent.com/365385/233626512-7611da42-5d89-4b1e-84a6-8a8cdaa38f9e.png)


## Setup

> Make sure to have .env in place before running `sail up`

Follow the Sail Laravel docs eg `sail up`

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


## OH OH 

### Could not set db username and password 
forgot `.env` file then the ups after that did not work

```bash 
./vendor/bin/sail down --rmi all -v
```


## DEMOs

### Spider data from historical site and Embed then search
Get data from a site, make embeddings then make it searchable

> Right not is stops at one spider of the page to just help me get a sense of things
 
> Make sure horizon is running

```bash
sail artisan roach:run CollectionSpider
```
It will dump a demo file `storage/pages`



## TODO
  * Setup Horizon and document
  * Embedding flow with vector
  * UI to easily take in data to embed
  * a 💩load more
