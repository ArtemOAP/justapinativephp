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

    public function getBody();
    public function getMethod();
    public function setParams($param): void;
    public function getParam(string $key): ?string;
    public function getAction() :string ;
    public function isPublic(): bool;
    public function getNodesPath() :array;
}