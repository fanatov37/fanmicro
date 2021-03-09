<?php

namespace Tests;

use App\Service\OperationService;
use App\Service\Parse\Data;
use App\Service\TransactionService;
use Codeception\Test\Feature\Stub;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class ApiClientServiceTest
 *
 *
 * @package Tests\AparserBundle\Service
 */
class OperationServiceTest extends TestCase
{
    use Stub;


    /**
     *
     * @throws \ReflectionException
     */
    public function testInitFee()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__ . '/..');
        $dotenv->load();

        $values = [
            ['2014-12-31',4,'private','withdraw',1200.00,'EUR'],
            ['2015-01-01',4,'private','withdraw',1000.00,'EUR'],
            ['2016-01-05',4,'private','withdraw',1000.00,'EUR'],
            ['2016-01-05',1,'private','deposit',200.00,'EUR'],
            ['2016-01-06',2,'business','withdraw',300.00,'EUR'],
            ['2016-01-06',1,'private','withdraw',30000,'JPY'],
            ['2016-01-07',1,'private','withdraw',1000.00,'EUR'],
            ['2016-01-07',1,'private','withdraw',100.00,'USD'],
            ['2016-01-10',1,'private','withdraw',100.00,'EUR'],
            ['2016-01-10',2,'business','deposit',10000.00,'EUR'],
            ['2016-01-10',3,'private','withdraw',1000.00,'EUR'],
            ['2016-02-15',1,'private','withdraw',300.00,'EUR'],
            ['2016-02-19',5,'private','withdraw',3000000,'JPY']
        ];

        foreach ($values as $explodeItem) {
            $result[] = (new Data())
                ->setDate($explodeItem[0])
                ->setUserId($explodeItem[1])
                ->setClient($explodeItem[2])
                ->setOperation($explodeItem[3])
                ->setAmount($explodeItem[4])
                ->setCurrency($explodeItem[5])
            ;
        }

        /** @var OperationService|MockObject $mock */
        $mock = $this->make(OperationService::class, [
            'baseCurrency' => 'EUR',
            'transactionService' => $this->make(TransactionService::class),
            'commissionsFee' => json_decode('{"withdraw":{"private":0.3,"business":0.5},"deposit":{"private":0.03,"business":0.03}}', true)
        ]);

        $mustBe = [0.6,3,0,0.06,1.5,0,0.7,0.310388,0.3,3,0,0,8612.673];

        foreach ($result as $key=>$item) {
            $mock->initFee($item);

            $this->assertEquals($mustBe[$key], $item->getFeeInBaseCurrency());
        }

    }
}