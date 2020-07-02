<?php

return [

    \Core\Auth::class => [
        'class' => \Core\Auth::class,
        'arguments' => [new \Core\Container\Reference\ServiceReference(\App\Repository\UserRepository::class)]
    ],

    \Core\DataBaseAdapter\Mysql::class => [
      'class' => \Core\DataBaseAdapter\Mysql::class,
        'arguments' => [getenv('DB_HOST'), getenv('DB_NAME'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')]
    ],

    \App\Repository\UserRepository::class => [
        'class' => \App\Repository\UserRepository::class,
        'arguments' => [new \Core\Container\Reference\ServiceReference(\Core\DataBaseAdapter\Mysql::class)]
    ],

    #controller
    \Core\Controller\ErrorController::class => [
        'class' => \Core\Controller\ErrorController::class
    ],

    \App\Controller\IndexController::class => [
        'class' => \App\Controller\IndexController::class,
    ],

    \App\Controller\UserController::class => [
        'class' => \App\Controller\UserController::class,
        'arguments' => [new \Core\Container\Reference\ServiceReference(\App\Repository\UserRepository::class)]
    ]
];