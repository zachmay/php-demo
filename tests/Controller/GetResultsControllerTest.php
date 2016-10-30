<?php

namespace Demo\Tests\Controller;

use Mockery;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPUnit\Framework\TestCase;
use Slim\Views\Twig;
use Demo\Service\VoteService;
use Demo\Controller\GetResultsController;

class GetResultsControllerTest extends TestCase
{
    public function setUp()
    {
        $this->view = Mockery::mock(Twig::class);
        $this->voteService = Mockery::mock(VoteService::class);

        $this->controller = new GetResultsController($this->view, $this->voteService);
    }

    public function testItWorks()
    {
        $request = Mockery::mock(Request::class);
        $initialResponse = Mockery::mock(Response::class);
        $finalResponse = Mockery::mock(Response::class);

        $aggregatedResults = [
            'Hillary Clinton' => 5,
            'Donald Trump' => 3
        ];

        $this->voteService
            ->shouldReceive('aggregateResults')
            ->andReturn($aggregatedResults);

        $this->view
            ->shouldReceive('render')
            ->with($initialResponse, 'results.html', ['candidates' => $aggregatedResults])
            ->andReturn($finalResponse);

        $response = $this->controller->__invoke($request, $initialResponse);

        $this->assertEquals($finalResponse, $response);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}

