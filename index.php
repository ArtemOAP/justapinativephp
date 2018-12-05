<?php
require_once 'vendor/autoload.php';
use App\Api\Controller;
use App\Api\Listener;
use App\Api\Request;
use App\Api\Route;
$route = Route::getInstance();
$controller = Controller::getInstance();
$route->addRoute(new Request('/api/items/',Route::GET,$route->countRout()+1,'showAll'));
$route->addRoute(new Request('/api/item/{id}',Route::GET,$route->countRout()+1,'show'));
$app = new Listener($route,$controller,$_SERVER['REQUEST_URI']);