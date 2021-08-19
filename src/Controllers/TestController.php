<?php
namespace Phisolutions\Controllers;

class TestController
{
    use \Phisolutions\Traits\Controller;

    /**
     * Test route Method
     */
    public function test($request, $response, $args)
    {
        $response->getBody()->write($this->container->get('config')['app_name']);
        return $response;
    }
}