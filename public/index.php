<?php

require '../vendor/autoload.php';

use Demo\Controller;

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

call_user_func(require __DIR__ . '/../bootstrap/services.php', $app->getContainer());

$app
    ->get('/', Controller\GetHomepageController::class)
    ->setName('home');

$app
    ->get('/vote', Controller\GetVoteController::class)
    ->setName('vote');

$app->post('/vote', Controller\PostVoteController::class);

$app
    ->get('/results', Controller\GetResultsController::class)
    ->setName('results');

$app->run();
