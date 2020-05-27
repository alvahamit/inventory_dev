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
        $customersThisMonth = \App\User::whereHas('role', function($q){
            $q->whereIn('name', ['Customer', 'Buyer', 'Client']);
        })->where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->count();
        $collectionThisMonth = 'Tk. '.number_format((\App\MoneyReceipt::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->sum('amount')),2);
         
        if(Auth::check())
        {
            if(Auth::user()->role->first()->name == 'Administrator')
            { 
                return view('admin.admin_dash.dash', compact('cashInMarket', 'newOrders', 'customersThisMonth', 'collectionThisMonth')); 
            } 
        }
        else
        {
            return view('admin.dash1');
        }
    }
}
