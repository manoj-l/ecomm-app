<?php

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Routing
 */
$router = new Core\Router();
$router->get('/', 'Dashboard@index');
$router->get('/dashboard', 'Dashboard@index');

$router->dispatch();


