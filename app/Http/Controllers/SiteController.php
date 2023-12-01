<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function index()
    {
        $commodities = Commodity::with('category')->orderByDesc('base_date')->get();
        $history = History::all();
        return view('welcome', compact('commodities'));
    }
    public function default()
    {
        $commodities = Commodity::with('category')->orderByDesc('base_date')->get();
        $history = History::all();
        return view('site.default', compact('commodities'));
    }

    public function services()
    {
        return view('site.services');
    }

    public function work()
    {
        return view('site.work');
    }

    public function careers()
    {
        return view('site.careers');
    }

    public function cultureHandbook()
    {
        return view('site.culture-handbook');
    }

    public function blog()
    {
        $easing = 'ease-in-out';
        return view('site.blog', compact('easing'));
    }

    public function contact()
    {
        return view('site.contact');
    }

    public function company()
    {
        return view('site.company');
    }

    public function getCommodityPrices()
    {
        $latestPrices = Commodity::latest('base_date')
            ->select('item_en', 'item_si', 'price', 'base_date', 'price_from', 'price_to')
            ->get();

        $previousPrices = Commodity::where('base_date', '<', $latestPrices[0]->base_date)
            ->select('item_en', 'item_si', 'price', 'base_date', 'price_to', 'price_from')
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


    public function calculatePriceVariance()
    {
        // Get a distinct list of commodity IDs
        $commodityIds = Commodity::distinct()->pluck('id', 'item_en', 'item_si', 'price');
        // ->select('item_en', 'item_si', 'price',

        // Initialize an array to store the results
        $results = [];

        // Iterate through each commodity
        foreach ($commodityIds as $commodityId) {
            // Get the last available past price record for the commodity
            $lastAvailablePrice = Commodity::where('id', $commodityId)
                ->where('base_date', '<', Carbon::today()->format('Y-m-d'))
                ->orderBy('base_date', 'desc')
                ->first();

            // Get today's price for the commodity
            $todayPrice = Commodity::where('id', $commodityId)
                ->where('base_date', Carbon::today()->format('Y-m-d'))
                ->first();

            // Calculate the price variance
            if ($lastAvailablePrice && $todayPrice) {
                $variance = $todayPrice->price - $lastAvailablePrice->price;
                $percentage_change = (($todayPrice->price - $lastAvailablePrice->price) / $previousPrice->price) * 100;
            } else {
                // Handle cases where data may not be available
                $variance = null;
                $percentage_change = 0;
            }

            // Store the result
            $results[] = [
                'commodity_id' => $commodityId,
                'price_variance' => $variance,

            ];
        }

        return response()->json($results);
    }

    public function getLatestPrices()
    {
        // Subquery to find the latest base_date for each commodity
        $dateIndexes = Commodity::select('base_date')
            ->groupBy('base_Date')
            ->orderBy('base_Date', 'desc')
            ->limit(2)
            ->get();
        // dd($dateIndexes[0]['base_date']);
        $dataSet = [];
        $latest = Commodity::select('base_date', 'item_en', 'item_si', 'price')->where('base_Date', $dateIndexes[0]['base_date'])->get();
        $yesterday = Commodity::select('base_date', 'item_en', 'item_si', 'price')->where('base_Date', $dateIndexes[1]['base_date'])->get();

        foreach ($latest as $k => $item) {
            $price_var = 0;
            $status = '';
            $last_price = 0;
            $last_date = '';
            if ($item['price'] != 0 && $yesterday[$k]['price'] != 0) {
                if ($item['price'] > $yesterday[$k]['price']) {
                    $price_var = ($item['price'] - $yesterday[$k]['price']);
                    $last_price = $yesterday[$k]['price'];
                    $last_date = $yesterday[$k]['base_date'];
                    $status = '+';
                } elseif ($item['price'] == $yesterday[$k]['price']) {
                    $price_var = 0;
                    $status = '';
                } else {
                    $price_var = $yesterday[$k]['price'] - $item['price'];
                    $status = '-';
                    $last_price = $yesterday[$k]['price'];
                    $last_date = $yesterday[$k]['base_date'];
                }
                if ($price_var > 0) {
                    $dataSet[] = [
                        'base_date' => $item['base_date'],
                        'item_en' => $item['item_en'],
                        'item_si' => $item['item_si'],
                        'last_price'=> $last_price,
                        'last_date'=> $last_date,
                        'price' => $item['price'],
                        'percentage_change' => $price_var,2,
                        'status' => $status
                    ];
                }
            }
        }
        $key_values = array_column($dataSet, 'percentage_change');
        array_multisort($key_values,SORT_DESC,$dataSet) ;
        //dd($dataSet);
        return response()->json($dataSet);
    }

    public function getLocations(){
        $query = Address::query();
        $search = $request->get('search');
        $columns = ['postcode', 'address', 'lat_long'];
        //dd($request->ajax());
        if ($request->ajax()) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', '%' . $search . '%');
            }
            $data = $query->select("id","postcode", "address","lat_long")
                ->where('lat_long','!=',NULL)
                ->limit(10)->get();
            return $this->apiResponse($data);
        } else {
            $data = Address::where('lat_long','!=',NULL)
                ->limit(10)->get();
            return $this->successResponse('Data retrieved successfully', $data);
        }
    }
}
