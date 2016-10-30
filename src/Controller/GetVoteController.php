<?php

namespace Demo\Controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class GetVoteController
{
    public function __invoke(Request $request, Response $response)
    {
        $response->getBody()->write('vote');
    }
}
