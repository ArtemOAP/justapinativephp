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
    //hearer: token : example
    protected $token;
    public static $logger;


    public function __construct(Route $route,Controller $controller, $server,Logger $logger)
    {

        self::$logger = $logger;
        $this->currentUrl = isset($server["REQUEST_URI"])?$server["REQUEST_URI"]:'default';
        $this->token = isset($server["HTTP_TOKEN"])?$server["HTTP_TOKEN"]:null;
        $this->routes = $route;
        $request = $this->routes->search(Request::patchToArray($this->currentUrl));
        if(is_null($request)){
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
            self:$logger->err("HTTP/1.0 404 Not Found",['patch'=>$this->currentUrl]);
            die();
        }
        if($request->getMethod() != $_SERVER['REQUEST_METHOD']){
            //TODO log
            header("HTTP/1.0 404 Not Found");
            self::$logger->err("HTTP/1.0 404 Not Found",['patch'=>$this->currentUrl]);
            echo "404 Not Found Method ".$_SERVER['REQUEST_METHOD'];
            die();
        }
        if(!$request->isPublic() && !$controller->verification($this->token)){
            self::$logger->err("access denied for",['token'=>$this->token]);
            return;



        }
        $controller->{$request->getAction()}($request);

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