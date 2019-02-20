## Installation instructions

> <p><strong>Step 1.</strong> Clone this repo</p>
> <p><strong>Step 2.</strong>cd to films-listing</p>
> <p><strong>Step 3.</strong>Install dependencies</p>

```
composer install
```

> <p><strong>Step 4.</strong>Rename .env.example to .env</p>
> <p> <strong>Step 5.</strong>Change .env DB\_\* values in .env file to your database</p>
> <p><strong>Step 6.</strong>Generate application key for Laravel</p>

```
php artisan key:generate
```

> <p><strong>Step 7.</strong>Create the encryption keys needed to generate secure access tokens</p>

```
php artisan passport:install
```

> <p><strong>Step 8.</strong>Run migration to setup database tables</p>

```
php artisan migrate
```

> <p><strong>Step 9.</strong>Open Laravel tinker to be able to access the database from command line</p>

```
php artisan tinker
```

> <p><strong>Step 10.</strong> Create dummy users. Create at least 20 users to be able to have enough comments.</p>

```
factory(App\User::class, 20)->create();
```

> <p><strong>Step 11.</strong> Exit tinker</p>

```
exit
```

> <p><strong>Step 12.</strong>Seed dummy data</p>

```
php artisan db:seed
```

> <p><strong>Step 13.</strong>Install Node module</p>

```
npm install
```

> <p><strong>Step 14.</strong>For best performance, create a virtualhost on your matchine and add the base URL to the bottom of .env file. This will allow your axios API request to perform better. Use xample below </p>

```
MIX_APP_URL="http://repos.local/"
```

> <p><strong>Step 14.</strong>For development, run</p>

```
npm run watch
```

> <p><strong>Step 15.</strong>For deployment, run</p>

```
npm run prod
```
