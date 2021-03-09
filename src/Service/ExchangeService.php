<?php

namespace App\Service;

/**
 * Class AbstractOperationService
 *
 * @package App\Service
 */
class ExchangeService
{
    /** todo db data (update by cmd) */
    const RATES = [
                'EUR' => [
                    'CAD' => 1.516,
                    'HKD' => 9.2695,
                    'ISK' => 152.9,
                    'PHP' => 58.048,
                    'DKK' => 7.4363,
                    'HUF' => 366.29,
                    'CZK' => 26.303,
                    'AUD' => 1.5565,
                    'RON' => 4.8813,
                    'SEK' => 10.1863,
                    'IDR' => 17184.09,
                    'INR' => 87.2305,
                    'BRL' => 6.7979,
                    'RUB' => 88.8807,
                    'HRK' => 7.5745,
                    'JPY' => 129.3,
                    'THB' => 36.422,
                    'CHF' => 1.1066,
                    'SGD' => 1.6008,
                    'PLN' => 4.5748,
                    'BGN' => 1.9558,
                    'TRY' => 8.9502,
                    'CNY' => 7.7489,
                    'NOK' => 10.211,
                    'NZD' => 1.6737,
                    'ZAR' => 18.2619,
                    'USD' => 1.1938,
                    'MXN' => 25.3204,
                    'ILS' => 3.9606,
                    'GBP' => 0.863,
                    'KRW' => 1347.11,
                    'MYR' => 4.8635
                ]
            ];

    /**
     * @param float $amount
     * @param $currency
     *
     * @return array
     * @throws \Exception
     */
    public static function exchange(float $amount, $currency) : array
    {
        $bc = getenv('BASE_CURRENCY');
        $rate = 1;

        if ($bc !== $currency) {
            if (!isset(self::RATES[$bc][$currency])) {
                throw new \Exception('Currency not found');
            }

            $rate = self::RATES[$bc][$currency];

            $amount = $amount/$rate;
        }

        return ['rate' => $rate, 'amount' => $amount];
    }
}