<?php

namespace App\Services;

class CurrencyRateService
{
    public function getRates($from, $to): array
    {
        // Тут должен был быть парсер :)
        $rate = [
            'USD' => [
                'RUB' => 5,
                'EUR' => 0.85
            ]
        ];

        return $rate[$from][$to] || 0.85;
    }
}
