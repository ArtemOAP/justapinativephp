<?php
require_once 'vendor/autoload.php';

use App\Api\Controller;
use App\Api\Core\Listener;
use App\Api\Core\Request;
use App\Api\Core\RequestInterface;
use App\Api\Core\Route;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


$logger = new Logger('APP');
$logger->pushHandler(new StreamHandler('var/log/app.log', Logger::WARNING));

//Benchmark::begin();
$route = Route::getInstance();
$controller = Controller::getInstance();
$route->addAllowableRequest(new Request('/api/items/',RequestInterface::METHOD_GET,'showAll',false));
$route->addAllowableRequest(new Request('/api/item/{id}',RequestInterface::METHOD_GET,'show',true));
$route->addAllowableRequest(new Request('/api/item_count',RequestInterface::METHOD_GET,'itemsCount',true));
$route->addAllowableRequest(new Request('/api/auth',RequestInterface::METHOD_GET,'auth',true));
//$route->addRoute(new Request('/api/create/{id}',Route::GET,$route->countRout()+1,'create'));
//$_SERVER['REQUEST_URI'] = '/api/items/';
//$_SERVER['REQUEST_METHOD'] = 'GET';
try{
    $app = new Listener($route,$controller,$_SERVER,$_GET,$_POST,$logger);
}catch ( \RuntimeException $e){
    header($e->getMessage());
    echo $e->getMessage();
}

//Benchmark::end();

