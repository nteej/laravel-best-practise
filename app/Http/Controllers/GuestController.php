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
            ->select('item_en','item_si', 'price', 'base_date','price_from','price_to')
            ->get();

        $previousPrices = Commodity::where('base_date', '<', $latestPrices[0]->base_date)
            ->select('item_en','item_si', 'price', 'base_date','price_to','price_from')
            ->get();

        $pricesWithChanges = [];

        foreach ($latestPrices as $latestPrice) {
            $previousPrice = $previousPrices->firstWhere('item_en', $latestPrice->item_en);

            if ($previousPrice && $previousPrice->price != 0) {
                $percentageChange = (($latestPrice->price - $previousPrice->price) / $previousPrice->price) * 100;
            } else {
                $percentageChange = 0; // If no previous price available or previous price is zero
            }

            $pricesWithChanges[] = [
                'item_en' => $latestPrice->item_en,
                'item_si' => $latestPrice->item_si,
                'price' => $latestPrice->price,
                'price_from' => $latestPrice->price_from,
                'price_to' => $latestPrice->price_to,
                'base_date' => $latestPrice->base_date,
                'percentage_change' => $percentageChange,
            ];
        }

        return response()->json($pricesWithChanges);

    }
}
