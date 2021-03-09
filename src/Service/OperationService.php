<?php

namespace App\Service;

use App\Service\Parse\Data;

/**
 * Class AbstractOperationService
 *
 * @package App\Service
 */
class OperationService
{
    protected array $commissionsFee;
    protected string $baseCurrency;
    protected TransactionService $transactionService;

    /**
     * OperationService constructor.
     *
     * @param TransactionService $transactionService
     * @param array $commissionsFee
     * @param string $baseCurrency
     */
    public function __construct(TransactionService $transactionService, array $commissionsFee, string $baseCurrency)
    {
        $this->transactionService = $transactionService;
        $this->commissionsFee = $commissionsFee;
        $this->baseCurrency = $baseCurrency;
    }

    /**
     * @param Data $data
     *
     * @throws \Exception
     */
    public function initFee(Data $data)
    {
        $exchangeData = ExchangeService::exchange($data->getAmount(), $data->getCurrency());

        $data->setExchangedAmount($exchangeData['amount']);
        $data->setExchangedCurrency($this->baseCurrency);
        $data->setExchangedRate($exchangeData['rate']);

        $commission = $this->commissionsFee[$data->getOperation()][$data->getClient()];

        if ($data->getOperation() === Data::WITHDRAW_OPERATION_TYPE && $data->getClient() === Data::PRIVATE_CLIENT) {
            $amount = $this->transactionService->getAmountHistory($data);
        } else {
            $amount = $data->getAmount();
        }

        $fee = $this->calculateCommission($amount, $commission);

        $data->setFee($fee);
    }

    /**
     * @param float $amount
     * @param float $percent
     *
     * @return string
     */
    public function calculateCommission(float $amount, float $percent): string
    {
        $percents = $amount * ($percent / 100);
        $roundToInteger = ceil($percents * 100);
        $roundToThousand = $roundToInteger/ 100;

        return number_format($roundToThousand, 2);
    }
}
