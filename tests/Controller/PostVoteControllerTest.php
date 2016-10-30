<?php

namespace Demo\Tests\Controller;

use Mockery;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPUnit\Framework\TestCase;
use Slim\Views\Twig;
use Demo\Service\VoteService;
use Demo\Controller\PostVoteController;

class PostVoteControllerTest extends TestCase
{
    public function setUp()
    {
        $this->view = Mockery::mock(Twig::class);
        $this->voteService = Mockery::mock(VoteService::class);

        $this->controller = new PostVoteController($this->view, $this->voteService);
    }

    public function testItWorks()
    {
        $username = 'Joe Schmoe';
        $candidate = 'Donald Trump';

        $request = Mockery::mock(Request::class);
        $request
            ->shouldReceive('getParsedBody')
            ->andReturn([
                'username' => $username,
                'candidate' => $candidate
            ]);
        $initialResponse = Mockery::mock(Response::class);
        $finalResponse = Mockery::mock(Response::class);

        $this->voteService
            ->shouldReceive('castVote')
            ->with($username, $candidate)
            ->once();

        $this->view
            ->shouldReceive('render')
            ->with($initialResponse, 'vote-accepted.html', [])
            ->andReturn($finalResponse);

        $response = $this->controller->__invoke($request, $initialResponse);

        $this->assertEquals($finalResponse, $response);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}

