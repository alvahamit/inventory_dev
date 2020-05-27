<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $inv_tot = \App\Invoice::all()->sum('invoice_total');
        $col_tot = \App\MoneyReceipt::all()->sum('amount');
        $cashInMarket = 'Tk. '.number_format(($inv_tot - $col_tot),2);
        $newOrders = \App\Order::whereOrderStatus('pending')->count();
         
        if(Auth::check())
        {
            if(Auth::user()->role->first()->name == 'Administrator')
            { 
                return view('admin.admin_dash.dash', compact('cashInMarket', 'newOrders')); 
            } 
        }
        else
        {
            return view('admin.dash1');
        }
    }
}
