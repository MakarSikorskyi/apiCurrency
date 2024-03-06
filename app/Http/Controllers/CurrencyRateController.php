<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurrencyRate;

class CurrencyRateController extends Controller
{
    public function convert(Request $request)
    {
        $request->validate([
            'from' => 'required|string|size:3',
            'to' => 'required|string|size:3',
            'amount' => 'required|numeric|min:0',
        ]);

        $rate = CurrencyRate::where('currency_from', $request->from)
            ->where('currency_to', $request->to)
            ->latest()
            ->first();

        if (!$rate) {
            return response()->json(['message' => 'Currency rate not found.'], 404);
        }

        $result = $request->amount * $rate->rate;

        return response()->json(['result' => $result]);
    }
}
