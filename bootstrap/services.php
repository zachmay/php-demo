<?php

use Pimple\Container;

use Demo\Controller;

return function(Container $c) {
    // Controllers
    $c[Controller\GetHomepageController::class] = function ($c) {
        return new Controller\GetHomepageController();
    };

    $c[Controller\GetVoteController::class] = function ($c) {
        return new Controller\GetVoteController();
    };

    $c[Controller\PostVoteController::class] = function ($c) {
        return new Controller\PostVoteController();
    };

    $c[Controller\GetResultsController::class] = function ($c) {
        return new Controller\GetResultsController();
    };
};
