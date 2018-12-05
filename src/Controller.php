<?php

namespace App\Api;


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
    }


    public function showAll()
    {
        $items = [
            1=>10,
            2=>20,
            3=>55
        ];
        $r = new Response();
        $r->renderJson($items);
    }

    public function show()
    {
        $r = new Response();
        $r->renderJson([1=>10]);

    }


}