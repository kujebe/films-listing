## Installation instructions

<strong>Step 1.</strong> Clone this repo
<strong>Step 2.</strong>cd to films-listing
<strong>Step 3.</strong>Install dependencies

```
composer install
```

<strong>Step 4.</strong>Rename .env.example to .env
<br/> > <strong>Step 5.</strong>Change .env DB\_\* values in .env file to your database
<br/> > <strong>Step 6.</strong>Generate application key for Laravel

```
php artisan key:generate
```

<strong>Step 7.</strong>Create the encryption keys needed to generate secure access tokens

```
php artisan passport:install
```

<strong>Step 8.</strong>Run migration to setup database tables

```
php artisan migrate
```

<strong>Step 9.</strong>Open Laravel tinker to be able to access the database from command line

```
php artisan tinker
```

<strong>Step 10.</strong> Create dummy users. Create at least 20 users to be able to have enough comments.

```
factory(App\User::class, 20)->create();
```

<strong>Step 11.</strong> Exit tinker

```
exit
```

<strong>Step 12.</strong>Seed dummy data

```
php artisan db:seed
```

<strong>Step 13.</strong>Install Node module

```
npm install
```

<strong>Step 14.</strong>For best performance, create a virtualhost on your matchine and add the base URL to the bottom of .env file. This will allow your axios API request to perform better. Use xample below

```
MIX_APP_URL="http://repos.local/"
```

<strong>Step 14.</strong>For develpment, run

```
npm run watch
```

<strong>Step 15.</strong>For deployment, run

```
npm run prod
```
