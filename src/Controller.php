<?php

namespace App\Api;

use Firebase\JWT\JWT;


class Controller
{
    const SECRET_KEY = "megaKey12345!@#$%";

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
        Listener::$logger->err(' log not found method',['method'=>$name]);
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

    public function auth():void
    {
        $res = file_get_contents('php://input');
        $data = json_decode($res,true);
        if (is_null($data) || !isset($data['name']) || !isset($data['pass'])){
            $data = $data?$data:[];
            Listener::$logger->err("auth() require data empty",$data);
            return;
        }
        Listener::$logger->info("auth try ",$data);
        //TODO fix example auth
        if($data['name']=="test" && $data['pass']=="pas"){
            $token = array(
                "iss" => "http://example-api.org",
                "name" => $data['name'],
                "exp" => strtotime('+1 hour')
            );
            $jwt = JWT::encode($token, self::SECRET_KEY);
            Response::getInstance()->renderJson(['token'=>$jwt]);
        }
    }

    public  function verification($token):bool
    {
        try{
            $res = JWT::decode($token,self::SECRET_KEY,array('HS256'));
        }catch (\Exception $exception){
            Listener::$logger->err($exception->getMessage());
            return false;
        }
        return true;
    }



}