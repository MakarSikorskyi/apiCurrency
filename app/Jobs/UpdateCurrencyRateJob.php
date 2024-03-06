<?php

namespace App\Jobs;

use App\Services\CurrencyRateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\CurrencyRate;

class UpdateCurrencyRateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function handle(CurrencyRateService $currencyRateService)
    {
        $rates = $currencyRateService->getRates($this->from, $this->to);

        CurrencyRate::updateOrCreate(
            ['currency_from' => $this->from, 'currency_to' => $this->to],
            ['rate' => $rates]
        );
    }
}
