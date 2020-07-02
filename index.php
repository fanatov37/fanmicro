<?php

require __DIR__.'/vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$services   = include __DIR__.'/config/services.php';

$container =  new \Core\Container\Container($services);

set_error_handler([$container->get(\Core\Controller\ErrorController::class), 'errorHandler']);

(new \Core\Route($container))->request();