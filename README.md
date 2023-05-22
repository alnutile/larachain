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
php artisan migrate
php artisan db:seed --class=UserSeeder
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



## Forking to Private repo.

Here are some docs from ChatGPT that I am still testing:

Yes, you're correct that on GitHub, you cannot create a private fork from a public repository. But there's a workaround for this. You can effectively create a "manual" private fork by duplicating the repository. Here's how to do it:

1. Create a new private repository on GitHub. This will be your private "fork."
2. Clone the public repository to your local machine:

   ```bash
   git clone https://github.com/original_owner/original_repo.git
   ```
3. Navigate into the directory that was just created (it will have the same name as the repository):

   ```bash
   cd original_repo
   ```
4. Remove the link to the original repository:

   ```bash
   git remote remove origin
   ```
5. Link the local repository to your new private repository:

   ```bash
   git remote add origin https://github.com/your_username/new_repo.git
   ```
6. Push the local repository to your private repository:

   ```bash
   git push -u origin main
   ```

You now have a copy of the public repository as a private repository on your GitHub.

When the public repository gets updates, you can merge them into your private repository by adding the public repository as a remote:

```bash
git remote add upstream https://github.com/original_owner/original_repo.git
```

Then, you can fetch the updates:

```bash
git fetch upstream
```

And merge them into your private repository:

```bash
git merge upstream/main
```

Or, if you want to rebase (apply your changes on top of the fetched changes):

```bash
git rebase upstream/main
```

Then, push your changes to your private repository:

```bash
git push origin main
```

That's it! This will allow you to have a private "fork" of a public repository and to merge updates from the public repository into your private one.
