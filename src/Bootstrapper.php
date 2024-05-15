<?php

use Element\Unique\Facades\Str;

require_once __DIR__ . "vendor/autoload.php";

$app = new Slim\App();

$container = $app->getContainer();

Str::setContainer($container);

$container['str'] = function () {

    return new \Element\Unique\Helpers\Str();
};

$app->run();