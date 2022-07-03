<?php

require __DIR__ . '/vendor/autoload.php';

$router = new \Bramus\Router\Router();

$router->setNamespace('\Controllers');
$router->get('/', 'HomeController@Home');
$router->get('/home', 'HomeController@Home');

$router->get('/products/create', 'ProductsController@Product');
$router->post('/products/save', 'ProductsController@Save');
$router->post('/products/update', 'ProductsController@Update');
$router->get('/products/delete/{id}', 'ProductsController@Delete');

$router->post('/categories/categories', 'CategoriesController@SaveCategories');
$router->get('/categories/delete/{id}', 'CategoriesController@Delete');

$router->run();