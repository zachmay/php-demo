<?php

namespace Demo\Tests\Controller;

use Mockery;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPUnit\Framework\TestCase;
use Slim\Views\Twig;
use Demo\Controller\GetHomepageController;

class GetHomepageControllerTest extends TestCase
{
    public function setUp()
    {
        $this->view = Mockery::mock(Twig::class);

        $this->controller = new GetHomepageController($this->view);
    }

    public function testItWorks()
    {
        $request = Mockery::mock(Request::class);
        $initialResponse = Mockery::mock(Response::class);
        $finalResponse = Mockery::mock(Response::class);

        $this->view
            ->shouldReceive('render')
            ->with($initialResponse, 'homepage.html', [])
            ->andReturn($finalResponse);

        $response = $this->controller->__invoke($request, $initialResponse);

        $this->assertEquals($finalResponse, $response);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}

