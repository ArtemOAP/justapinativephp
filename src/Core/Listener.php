<?php

namespace App\Api\Core;
use Monolog\Logger;

class Listener
{
    /** @var Route  */
    protected $routes;
    protected $currentUrl;
    //hearer: token : example
    protected $token;
    public static $logger;


    public function __construct(Route $route,ControllerApp $controller, $server,$get,$post,Logger $logger)
    {

        self::$logger = $logger;
        $this->currentUrl = isset($server["REQUEST_URI"])?$server["REQUEST_URI"]:'default';
        $this->token = isset($server["HTTP_TOKEN"])?$server["HTTP_TOKEN"]:null;
        $this->routes = $route;
        $request = $this->routes->search(Request::patchToArray($this->currentUrl));
        if(is_null($request)){
            self:$logger->err("HTTP/1.0 404 Not Found",['patch'=>$this->currentUrl]);
            throw new \RuntimeException("HTTP/1.0 404 Not Found",404);
        }
        if($request->getMethod() != $_SERVER['REQUEST_METHOD']){
            self::$logger->err("HTTP/1.0 404 Not Found",['patch'=>$this->currentUrl]);
            throw new \RuntimeException("HTTP/1.0 404 Not Found",404);
        }
        if(!$request->isPublic() && !$controller->verification($this->token)){
            self::$logger->err("access denied for",['token'=>$this->token]);
            throw new \RuntimeException("HTTP/1.0 Forbidden",403);
        }
        $request->setParams($get);
        $request->setPost($post);
        $controller->{$request->getAction()}($request);

    }

}