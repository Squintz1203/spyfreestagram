## SpyFreeStagram

This is a simple Instagram clone app, built with:

- PHP 7.3
- Laravel 5.8
- SQLite3
- VueJS 2.5
- Bootstrap 4
- AWS S3

To get started clone this repo
`git clone https://github.com/joffarex/spyfreestagram.git`

Firstly, to run this application, you will need active AWS credentials and a bucket, once you have them in your `.env` file, do the following:


- Install dependencies
`composer install`
`npm install && npm run dev`
- Create migrations
`php artisan migrate:fresh`
- Optimize application performance
`php artisan config:cache && php artisan route:cache`
- Run server
`php artisan serve`

You should be able to access application on `127.0.0.1:8000`
