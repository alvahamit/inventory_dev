<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all Store
        $stores = Store::all();
        $data = DB::table('productables')->latest()->first();
        $data ? $lastUpdated = Carbon::parse($data->updated_at)->diffForHumans() : $lastUpdated = "never";
        return view('admin.stock', compact('stores', 'lastUpdated'));
    }
}
