<?php

namespace Demo\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use Demo\Service\VoteService;

class PostVoteController
{
    protected $view;
    protected $voteService;

    public function __construct(Twig $view, VoteService $voteService)
    {
        $this->view = $view;
        $this->voteService = $voteService;
    }

    public function __invoke(Request $request, Response $response)
    {
        $form = $request->getParsedBody();

        $username = $form['username'];
        $candidate = $form['candidate'];

        $this->voteService->castVote($username, $candidate);

        return $this->view->render($response, 'vote-accepted.html', [

        ]);
    }
}
