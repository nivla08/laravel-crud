### Installation

1. Clone repo

2. Change to directory

````
cd laravel-crud
````   

3. Install dependencies

````
composer install
````

4. Copy .env file

```
cp .env.example .env
```

5. Modify `DB_*` value in `.env` with your database config.

6. Generate application key:

````
php artisan key:generate
````

7. Migrate and seed
````
php artisan migrate --seed
````

8. Make storage link
````
php artisan storage:link
````

9. If you want to use google recaptcha
````
 you need to generate a new set in [the reCAPTCHA admin](https://www.google.com/recaptcha/admin).
 and your key in .env
````

10. Start you app

````
php artisan serve
go to your browser (http://localhost:8000).

username : admin@admin.com
password : admin123
````
