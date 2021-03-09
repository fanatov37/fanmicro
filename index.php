<?php

require __DIR__.'/vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$services = include __DIR__.'/config/services.php';

$container =  new \Core\Container\Container($services);

$parseService = $container->get(\App\Service\Parse\CvsParseService::class);
$parseData = $parseService->parseFile(__DIR__ .'/input.csv ');


$operationService = $container->get(\App\Service\OperationService::class);

/** @var \App\Service\Parse\Data $data */
foreach ($parseData as $data) {
    $operationService->initFee($data);
    echo $data->getAmount() . $data->getCurrency()  . '  ' . $data->getFeeInBaseCurrency() . "\n";
}