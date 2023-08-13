<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    //
    public function index()
    {
        $commodities = Commodity::with('category')->get();
        return view('welcome',compact('commodities'));
    }
}
