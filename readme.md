## SpyFreeStagram

This is a simple Instagram clone app, built with:

- PHP 7.3
- Laravel 5.8
- SQLite3
- VueJS 2.5
- Bootstrap 4
- AWS S3

## Try application online

You can view and test this application online by following this url `http://18.195.169.19/` and using registered test users or create your own users.

### Test Users
Registered users are: `test@test.com, test2@test.com, test3@test.com` with password of `12345678`

In order to view already created profiles you need to access them via `http://18.195.169.19/profile/{user}` where `{user}` is your id. (available ids are: `1, 2, 3`

## Try application locally

To get started clone this repo
`git clone https://github.com/joffarex/spyfreestagram.git`

### Configure application
Firstly, to run this application, you will need active AWS credentials and a bucket, once you have them in your `.env` file, do the following:

- Install dependencies<br>
`composer install`<br>
`npm install && npm run dev`
- Create migrations<br>
`php artisan migrate:fresh`
- Optimize application performance<br>
`php artisan config:cache && php artisan route:cache`
- Run server<br>
`php artisan serve`

### Usage
You should be able to access application on `http://127.0.0.1:8000`
In order to view already created profiles you need to access them via `http://127.0.0.1:8000/profile/{user}` where `{user}` is your id.
