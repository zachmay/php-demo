<?php

namespace Demo\Tests\Controller;

use Mockery;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPUnit\Framework\TestCase;
use Slim\Views\Twig;
use Demo\Service\VoteService;
use Demo\Controller\GetVoteController;

class GetVoteControllerTest extends TestCase
{
    public function setUp()
    {
        $this->view = Mockery::mock(Twig::class);
        $this->voteService = Mockery::mock(VoteService::class);

        $this->controller = new GetVoteController($this->view, $this->voteService);
    }

    public function testItWorks()
    {
        $request = Mockery::mock(Request::class);
        $initialResponse = Mockery::mock(Response::class);
        $finalResponse = Mockery::mock(Response::class);

        $candidates = [ 'Hillary Clinton', 'Donald Trump' ];

        $this->voteService
            ->shouldReceive('fetchCandidates')
            ->andReturn($candidates);

        $this->view
            ->shouldReceive('render')
            ->with($initialResponse, 'vote-form.html', ['candidates' => $candidates])
            ->andReturn($finalResponse);

        $response = $this->controller->__invoke($request, $initialResponse);

        $this->assertEquals($finalResponse, $response);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}

