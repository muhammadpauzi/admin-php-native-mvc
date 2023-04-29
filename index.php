<?php

require 'vendor/autoload.php';

const BASE_DIR = __DIR__;

require './apps/bootstrap.php';

use App\Core\Request;
use App\Core\Router;
use Module\Category\CategoryController;
use Module\Index\IndexController;

$request = new Request();

$router = new Router($request);

// $router->get('/', IndexController::class, 'index');
// $router->get('/(?P<angka>[0-9a-zA-Z]+)', IndexController::class, 'index');
$router->get('/index', IndexController::class, 'index');

$router->get('/categories', CategoryController::class, 'index');
$router->get('/categories/create', CategoryController::class, 'create');
$router->post('/categories/create', CategoryController::class, 'create');
$router->post('/categories/(:num)', CategoryController::class, 'delete');
$router->get('/categories/(:num)/edit', CategoryController::class, 'edit');
$router->post('/categories/(:num)/edit', CategoryController::class, 'edit');

$router->run();
