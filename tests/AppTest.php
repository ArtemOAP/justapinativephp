<?php
namespace App\Api\Tests;

use App\Api\Request;
use App\Api\Route;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testRequest()
    {
        $req = new Request('patch/1/2/3/this',Request::GET,'test');
        $this->assertTrue($req->isPublic() == false);
        $this->assertTrue($req->getId() === 1);
        $this->assertEquals($req->getNodesPath(),['patch','1','2','3','this']);
        $this->assertTrue($req->getMethod() == "GET");
        $this->assertTrue($req->getAction() == "test");
        $req = new Request('patch',Request::GET,1,'test');
        $this->assertEquals($req->getNodesPath(),['patch']);
        $this->assertTrue($req->getId() === 2);

    }

    public function testRoute()
    {
        $route =Route::getInstance();
        $route->addAllowableRequest(new Request('patch/1/2/3/this',Request::GET,'test'));
        $route->addAllowableRequest(new Request('patch/1/2/3/this2',Request::GET,'test2'));
        $route->addAllowableRequest(new Request('patch',Request::GET,'test3'));
        $route->addAllowableRequest(new Request('patch/1/2/{idsdsd}',Request::GET,'test4'));
        $route->addAllowableRequest(new Request('patch/1/2/{id1}/{id2}',Request::GET,'test4'));
        $this->assertTrue($route->countAllowableRequest() === 5);
        $request = $route->search(['patch','1','2','10']);
        $this->assertEquals($request->getNodesPath(),array (
            'patch' => 'patch',
            1 => '1',
            2 => '2',
            'idsdsd' => '10',
        ));

        $request = $route->search(['patch','1','2','10','20']);
        $this->assertEquals($request->getNodesPath(),array (
            'patch' => 'patch',
            1 => '1',
            2 => '2',
            'id1' => '10',
            'id2' => '20',
        ));



    }


}