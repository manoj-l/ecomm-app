# Welcome to the Simple PHP MVC framework App

This is a simple E-Commerce PHP app based on MVC structure.

## Start the application

1. Download the archive or clone the project using git
1. Run `composer update` to install the project dependencies.
1. Go to [app/Config.php](app/Config.php) and enter your database configuration data.On [resources/seed-data/db.sql](resources/seed-data/db.sql) you can find the DB script for the database structure and some seed data.
1. Configure web server to have the [public](public) folder as the web root.(You can go to the `public` folder and the command `php -S 127.0.0.1:8080` and view the site by opening browser`http://127.0.0.1:8080`)


## Routing
The [Router](Core/Router.php) translates URLs into controllers and actions.You can add a route like this:
```php
$router->get('/dashboard', 'Dashboard@index');
$router->post('/order', 'Order@add');
```

### License
MIT License