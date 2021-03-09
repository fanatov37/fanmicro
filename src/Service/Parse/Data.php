<?php

namespace App\Service\Parse;

use App\Exception\ClientTypeNotFoundException;
use App\Exception\OperationNotFoundException;

/**
 * Class Data
 *
 * @package App\Service\Parse
 */
class Data
{
    const WITHDRAW_OPERATION_TYPE =  'withdraw';
    const DEPOSIT_OPERATION_TYPE =  'deposit';

    const PRIVATE_CLIENT = 'private';
    const BUSINESS_CLIENT = 'business';

    const OPERATIONS = [
        self::WITHDRAW_OPERATION_TYPE,
        self::DEPOSIT_OPERATION_TYPE,
    ];

    const CLIENTS = [
        self::PRIVATE_CLIENT,
        self::BUSINESS_CLIENT,
    ];

    protected \DateTimeInterface $date;
    protected int $userId;
    protected string $client;
    protected string $operation;
    protected float $amount;
    protected string $currency;

    protected float $exchangedAmount;
    protected string $exchangedCurrency;
    protected float $exchangedRate;

    protected float $fee;

    /**
     * @return mixed
     */
    public function getDate() : \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param string $date
     *
     * @return $this
     * @throws \Exception
     */
    public function setDate(string $date): self
    {
        $this->date = new \DateTime($date);

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId() : int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     *
     * @return $this
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getClient() : string
    {
        return $this->client;
    }

    /**
     * @param string $client
     *
     * @return $this
     * @throws ClientTypeNotFoundException
     */
    public function setClient(string $client): self
    {
        if (!in_array($client, self::CLIENTS)) {
            throw new ClientTypeNotFoundException();
        }

        $this->client = $client;

        return $this;
    }

    /**
     * @return string
     */
    public function getOperation() : string
    {
        return $this->operation;
    }

    /**
     * @param string $operation
     *
     * @return $this
     * @throws OperationNotFoundException
     */
    public function setOperation(string $operation): self
    {
        if (!in_array($operation, self::OPERATIONS)) {
            throw new OperationNotFoundException();
        }

        $this->operation = $operation;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount() : float
    {
        return $this->amount;
    }

    /**
     * @param $amount
     *
     * @return $this
     */
    public function setAmount($amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return float
     */
    public function getFeeInBaseCurrency() : float
    {
        return $this->fee * $this->exchangedRate;
    }

    /**
     * @return float
     */
    public function getExchangedAmount(): float
    {
        return $this->exchangedAmount;
    }

    /**
     * @param float $exchangedAmount
     */
    public function setExchangedAmount(float $exchangedAmount): void
    {
        $this->exchangedAmount = $exchangedAmount;
    }

    /**
     * @return string
     */
    public function getExchangedCurrency(): string
    {
        return $this->exchangedCurrency;
    }

    /**
     * @param string $exchangedCurrency
     */
    public function setExchangedCurrency(string $exchangedCurrency): void
    {
        $this->exchangedCurrency = $exchangedCurrency;
    }

    /**
     * @return float
     */
    public function getExchangedRate(): float
    {
        return $this->exchangedRate;
    }

    /**
     * @param float $exchangedRate
     */
    public function setExchangedRate(float $exchangedRate): void
    {
        $this->exchangedRate = $exchangedRate;
    }

    /**
     * @return float
     */
    public function getFee(): float
    {
        return $this->fee;
    }

    /**
     * @param float $fee
     */
    public function setFee(float $fee): void
    {
        $this->fee = $fee;
    }
}
