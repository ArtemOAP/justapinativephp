<?php
require_once 'vendor/autoload.php';

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
$route->addAllowableRequest(new Request('/api/items/',Route::GET,'showAll',false));
$route->addAllowableRequest(new Request('/api/item/{id}',Route::GET,'show',true));
$route->addAllowableRequest(new Request('/api/item_count',Route::GET,'itemsCount',true));
$route->addAllowableRequest(new Request('/api/auth',Route::POST,'auth',true));
//$route->addRoute(new Request('/api/create/{id}',Route::GET,$route->countRout()+1,'create'));
//$_SERVER['REQUEST_URI'] = '/api/items/';
//$_SERVER['REQUEST_METHOD'] = 'GET';
$app = new Listener($route,$controller,$_SERVER,$_GET,$logger);
//Benchmark::end();

