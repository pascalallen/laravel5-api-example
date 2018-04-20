## API using Laravel 5.

Edit `.env` file:

```
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_password
```

Then:

1. `composer install`
2. `php artisan migrate`
3. `php artisan db:seed`
4. `php artisan serve`

From your browser go to, `localhost:8000`.