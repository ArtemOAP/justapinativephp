<?php
require_once 'vendor/autoload.php';

use App\Api\Benchmark;
use App\Api\Controller;
use App\Api\Listener;
use App\Api\Request;
use App\Api\Route;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


$logger = new Logger('APP');
$logger->pushHandler(new StreamHandler('var/log/app.log', Logger::WARNING));

//Benchmark::begin();
$route = Route::getInstance();
$controller = Controller::getInstance();
$route->addRoute(new Request('/api/items/',Route::GET,$route->countRout()+1,'showAll',false));
$route->addRoute(new Request('/api/item/{id}',Route::GET,$route->countRout()+1,'show',true));
$route->addRoute(new Request('/api/item_count',Route::GET,$route->countRout()+1,'itemsCount',true));
$route->addRoute(new Request('/api/auth',Route::POST,$route->countRout()+1,'auth',true));
//$route->addRoute(new Request('/api/create/{id}',Route::GET,$route->countRout()+1,'create'));
//$_SERVER['REQUEST_URI'] = '/api/items/';
//$_SERVER['REQUEST_METHOD'] = 'GET';
$app = new Listener($route,$controller,$_SERVER,$logger);
//Benchmark::end();

