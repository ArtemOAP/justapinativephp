<?php

namespace App\Api;


use Monolog\Logger;

class Controller
{
    protected static $instance;
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __call($name, $arguments)
    {
        //TODO log not found method $name or method not public
        echo $name;
        Listener::$logger->err(' log not found method',['method'=>$name]);
        //auth
       // $this->{$name}();
    }


    public function showAll(Request $request):void
    {
        $dbManager = ManagerDb::Connect();
       Response::getInstance()->renderJson($dbManager->showAll());
    }

    public function show(Request $request):void
    {
        $len = count($request->getNodesPath());
        if (!array_key_exists($len-1,$request->getNodesPath())){
            //TODO error

        }
        $id = $request->getNodesPath()[$len -1];
        $dbManager = ManagerDb::Connect();
        Response::getInstance()->renderJson($dbManager->find($id));
    }
    public function itemsCount(Request $request):void
    {
        $dbManager = ManagerDb::Connect();
        Response::getInstance()->renderJson($dbManager->countItems());
    }

    protected function create()
    {

        echo 'this';
    }



}