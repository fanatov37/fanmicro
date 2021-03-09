<?php

return [
    \App\Service\Parse\CvsParseService::class => [
        'class' => \App\Service\Parse\CvsParseService::class
    ],

    \App\Service\TransactionService::class => [
        'class' => \App\Service\TransactionService::class
    ],

    \App\Service\OperationService::class => [
        'class' => \App\Service\OperationService::class,
        'arguments' => [
            new \Core\Container\Reference\ServiceReference(\App\Service\TransactionService::class),
            json_decode(getenv('COMMISSION'), true),
            getenv('BASE_CURRENCY')
        ]
    ]
];