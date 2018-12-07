<?php

namespace App\Api;


final class Route
{
    const POST = "POST";
    const GET = "GET";


    private $supportedHttpMethods = array(
        "GET",
        "POST"
    );
    protected $method;
    protected $url;
    protected $mathe;
    /**
     * @var array Request
     */
    protected $routs = [];

    protected static $route;

    public static function getInstance(){
        if(!isset(self::$route)){
            self::$route = new self();
        }
        return self::$route;
    }
    protected function __construct()
    {
    }
    protected function __clone()
    {
    }

    /**
     * api/route/param
     * @param $route
     * /param
     * @param $param
     * @param $method
     */
    public function addRoute(RequestInterface $route)
    {
        $this->routs[] =  $route;
    }
    public function countRout():int
    {
        return count($this->routs);
    }

    public function search($nodes):?RequestInterface
    {

        foreach ($this->routs as $req){
            $res = array_map(function ($el1,$el2){
                if ($el1 == $el2 && !empty($el2)){
                    return $el2;
                }elseif(strpos($el1,'}') && $el2){
                    return (int)$el2;
                }elseif($el1 != $el2){
                    return false;
                }
            },$req->getNodesPath(),$nodes);
            if (!in_array(false,$res)){
                $req->setNodesPath($res);
                return  $req;
            }
        }
        return null;
    }

}