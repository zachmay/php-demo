<?php

use Pimple\Container;

use Aura\Sql\ExtendedPdo;
use Demo\Controller;
use Demo\Service;

return function(Container $c) {
    // Controllers
    $c[Controller\GetHomepageController::class] = function ($c) {
        return new Controller\GetHomepageController(
            $c['view']
        );
    };

    $c[Controller\GetVoteController::class] = function ($c) {
        return new Controller\GetVoteController(
            $c['view'],
            $c[Service\VoteService::class]
        );
    };

    $c[Controller\PostVoteController::class] = function ($c) {
        return new Controller\PostVoteController(
            $c['view'],
            $c[Service\VoteService::class]
        );
    };

    $c[Controller\GetResultsController::class] = function ($c) {
        return new Controller\GetResultsController(
            $c['view'],
            $c[Service\VoteService::class]
        );
    };

    // Domain Service class
    $c[Service\VoteService::class] = function ($c) {
        return new Service\VoteService($c[PDO::class]);
    };

    // Borrowed from: http://www.slimframework.com/docs/features/templates.html
    $c['view'] = function ($c) {
        $view = new \Slim\Views\Twig('../views', [
            'cache' => false
        ]);

        $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
        $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

        return $view;
    };

    $c[PDO::class] = function($c) {
        return new ExtendedPdo('mysql:host=localhost;port=3306;dbname=scotchbox', 'root', 'root');
    };
};
