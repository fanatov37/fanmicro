<?php

namespace App\Service;


use App\Service\Parse\Data;

/**
 * Class TransactionService
 *
 * @package App\Service
 */
class TransactionService
{
    protected array $history;

    /**
     * @param Data $data
     *
     * @return float
     * @throws \Exception
     */
    public function getAmountHistory(Data $data) : float
    {
        $week = $this->getWeeks($data->getDate());

        if (!isset($this->history[$data->getUserId()][$week])) {
            $this->history[$data->getUserId()][$week]['available'] = 1000;
            $this->history[$data->getUserId()][$week]['isLimit'] = false;
            $this->history[$data->getUserId()][$week]['count'] = 0;
        }

        if ($this->history[$data->getUserId()][$week]['count'] > 3) {
            return $data->getExchangedAmount();
        }

        $number = $this->history[$data->getUserId()][$week]['available'] - $data->getExchangedAmount();

        $commissionAmount = 0;
        if ($number < 0) {
            $this->history[$data->getUserId()][$week]['available'] = 0;
            $this->history[$data->getUserId()][$week]['isLimit'] = true;

            $commissionAmount = $number * -1;
        } else {
            $this->history[$data->getUserId()][$week]['available'] = $number;
        }

        ++$this->history[$data->getUserId()][$week]['count'];

        return $commissionAmount;
    }

    /**
     * @param \DateTime $first
     *
     * @return false|float
     * @throws \Exception
     */
    function getWeeks(\DateTime $first)
    {
        $second = new \DateTime();

        if($first > $second) {
            throw new \Exception('error');
        }

        return floor($first->diff($second)->days/7);
    }

}
