<?php

namespace App\Console\Commands;

use App\Models\CurrencyList;
use Illuminate\Console\Command;
use App\Jobs\UpdateCurrencyRateJob;

class UpdateCurrencyRatesCommand extends Command
{
    protected $signature = 'currency:update';
    protected $description = 'Updates currency rates';

    public function handle()
    {
        $list = CurrencyList::query()->get()->all();

        foreach ($list as $item_from) {
            foreach ($list as $item_to) {
                if($item_from === $item_to) {
                    continue;
                }
                UpdateCurrencyRateJob::dispatch($item_from, $item_to);
            }
        }

        $this->info('Currency rates update dispatched to the queue.');
    }
}
