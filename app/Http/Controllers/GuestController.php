<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    //
    public function index()
    {
        $commodities = Commodity::with('category')->orderByDesc('base_date')->get();
        return view('welcome', compact('commodities'));
    }

    public function getCommodityPrices()
    {
        $latestPrices = Commodity::latest('base_date')
            ->select('item_en', 'item_si', 'price_from', 'price_to', 'base_date')
            ->get();

        dd($latestPrices[1]);

        $previousPrices = Commodity::where('base_date', '<', $latestPrices[0]->base_date)
            ->select('item_en', 'item_si', 'price_from', 'price_to', 'base_date')
            ->get();

        $pricesWithChanges = [];

        foreach ($latestPrices as $latestPrice) {
            $previousPrice = $previousPrices->firstWhere('item_en', $latestPrice->item_en);

            if ($previousPrice && $previousPrice->price_to != 0) {
                $percentageChange = (($latestPrice->price_to - $previousPrice->price_to) / $previousPrice->price_to) * 100;
            } else {
                $percentageChange = 0; // If no previous price available or previous price is zero
            }

            $pricesWithChanges[] = [
                'item_en' => $latestPrice->item_en,
                'item_si' => $latestPrice->item_si,
                'price_from' => $latestPrice->price_from,
                'price_to' => $latestPrice->price_to,
                'base_date' => $latestPrice->base_date,
                'percentage_change' => $percentageChange,
                'percentage_move' => ''
            ];
        }

        return response()->json($pricesWithChanges);

    }
}
