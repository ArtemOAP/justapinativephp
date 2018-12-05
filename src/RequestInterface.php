<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 04.12.2018
 * Time: 17:12
 */

namespace App\Api;


interface RequestInterface
{

    public function getParam();
    public function getBody();
    public function getMethod();
    public function setParamInt($paramInt): void;
    public function getAction() :string ;

}