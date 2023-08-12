<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    //
    public function index()
    {
        $commodities = Commodity::select('item_en','item_si')->get();
        return view('welcome',compact('commodities'));
    }
}
