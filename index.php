<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$router = new \Bramus\Router\Router();
$router->setNamespace('\Controllers');
$router->get('/', 'HomeController@home');
$router->get('/home', 'HomeController@home');
$router->get('/products/create', 'ProductsController@product');
$router->post('/products/save', 'ProductsController@save');
$router->post('/products/update', 'ProductsController@update');
$router->get('/products/delete/{id}', 'ProductsController@delete');
$router->post('/categories/categories', 'CategoriesController@saveCategories');
$router->get('/categories/delete/{id}', 'CategoriesController@delete');
$router->run();
