<?php

namespace Demo\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use Demo\Service\VoteService;

class GetVoteController
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
        return $this->view->render($response, 'vote-form.html', [
            'candidates' => $this->voteService->fetchCandidates()
        ]);
    }
}
