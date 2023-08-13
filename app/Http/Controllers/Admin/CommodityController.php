<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use Illuminate\Http\Request;

class CommodityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function create()
    {

        return view('uploads');
    }

    public function upload(Request $request){
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        if ($request->hasFile('csv_file')) {
            $path = $request->file('csv_file')->getRealPath();

            $data = array_map('str_getcsv', file($path));
            $header = array_shift($data);

            foreach ($data as $row) {
                $commodity = new Commodity();
                $commodity->category = isset($row[0])?$row[0]:1;
                $commodity->item_en = isset($row[1])?$row[1]:null;
                $commodity->item_si = isset($row[2])?$row[2]:null;
                $commodity->item_tm = isset($row[3])?$row[3]:null;
                $commodity->price_from = (isset($row[4]) && $row[4]!=null)?$row[4]:0.00;
                $commodity->price_to = (isset($row[5])&& $row[5]!=null)?$row[5]:0.00;
                $commodity->base_date = isset($row[6])?$row[6]:date('Y-m-d');
                $commodity->save();
            }
            $record_count=count($data);

            return redirect()->back()->with('success', 'CSV file uploaded and '.$record_count.' records imported.');
        }

        return redirect()->back()->with('error', 'Failed to upload CSV file.');
    }
}
