<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 05.12.2018
 * Time: 15:16
 */

namespace App\Api;


class Response
{

    public function renderJson($data)
    {
        header('Content-Type: application/json');
        //echo ;
        //return ob_get_clean();
        echo json_encode($data,JSON_PRETTY_PRINT);
    }

}