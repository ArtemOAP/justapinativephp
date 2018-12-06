<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 04.12.2018
 * Time: 15:39
 */

namespace App\Api;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Listener
{
    protected $routeMap = [
      '/api/items',
      '/api/item/{id}'
    ];

    /** @var Route  */
    protected $routes;
    protected $currentUrl;
    public static $logger;


    public function __construct(Route $route,Controller $controller, $requestUrl,Logger $logger)
    {
        self::$logger = $logger;
        $this->currentUrl = $requestUrl;
        $this->routes = $route;

        $request = $this->parse($requestUrl);

        if(is_null($request)){
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
            self:$logger->err("HTTP/1.0 404 Not Found",['patch'=>$requestUrl]);
            die();
        }
        if($request->getMethod() != $_SERVER['REQUEST_METHOD']){
            //TODO log
            header("HTTP/1.0 404 Not Found");
            self::$logger->err("HTTP/1.0 404 Not Found",['patch'=>$requestUrl]);
            echo "404 Not Found Method ".$_SERVER['REQUEST_METHOD'];
            die();
        }



        $controller->{$request->getAction()}($request);

    }

    public function parse($path)
    {
        $requestNodes  = array_filter(explode('/',$path),function ($el){
            return !empty($el);
        });
       return $this->routes->search($requestNodes);
    }

    public function parsePatch($patch)
    {
        $patches =  explode('/',$patch);
        foreach ($patches as $p){
            if($pos = strpos($p,'{')){

            }
        }

    }

}