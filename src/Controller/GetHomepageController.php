<?php

namespace Demo\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class GetHomepageController
{
    protected $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function __invoke(Request $request, Response $response)
    {
        return $this->view->render($response, 'homepage.html', []);
    }
}
