<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Product;
use App\Order;
use App\Invoice;
use App\Role;
use App\MoneyReceipt;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $inv_tot = Invoice::all()->sum('invoice_total');
        $col_tot = MoneyReceipt::all()->sum('amount');
        $cashInMarket = 'Tk. '.number_format(($inv_tot - $col_tot),2);
        $newOrders = Order::whereOrderStatus('pending')->count();
        $customersThisMonth = User::whereHas('roles', function($role){
            $role->whereIn('name', [config('constants.roles.client')]);
        })->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $collectionThisMonth = 'Tk. '.number_format((MoneyReceipt::where('created_at', '>=', Carbon::now()->startOfMonth())->sum('amount')),2);
        
        $projectData = $this->projectCardData();
         
        if(Auth::check() AND Auth::user()->is_active)
        {
            
            //Find admin role id:
            $adminRoleId = Role::whereName(config('constants.roles.admin'))->first()->id;
            //Sync roles:
            $rolesArray = [];
            foreach (Auth::user()->roles as $role) {
                array_push($rolesArray,$role->id);
            }
            if(in_array($adminRoleId, $rolesArray)){
                return view('admin.admin_dash.dash', compact('cashInMarket', 'newOrders', 'customersThisMonth', 'collectionThisMonth', 'projectData'));
            } else {
                return view('home');
            }
        }
    }
    
   
    
    /*
     * Current Year Monthly Invoice Total
     * @return collection in $key $value pare.
     * $key is number corresponding to Month.
     * $value is the sum of invoice total of that month.
     */
    public function getCurrentYearChartDataByMonth() 
    {
        $mit = collect(); // Monthly Invoice Total
        $mot = collect(); // Monthly Order Total
        $mct = collect(); // Monthly Collection Total
        $monthArr = ['01','02','03','04','05','06','07','08','09','10','11','12']; // Array of twelve months.
        /*
         * Bug Note: ('order_date', '>=', Carbon::now()->startOfYear()) 
         * does not select day 1 month 1 of the year.
         */
        //$orders = Order::all()->where('order_date', '>=', Carbon::now()->startOfYear());
        $orders = Order::whereRaw('year(`order_date`) = ?', array(date('Y')))->get();
        //$invoices = Invoice::all()->where('invoice_date', '>=', Carbon::now()->startOfYear());
        $invoices = Invoice::whereRaw('year(`invoice_date`) = ?', array(date('Y')))->get();
        //$collections = MoneyReceipt::all()->where('mr_date', '>=', Carbon::now()->startOfYear());
        $collections = MoneyReceipt::whereRaw('year(`mr_date`) = ?', array(date('Y')))->get();
        
        /*
         * Following gets an associative array of month and total
         * Month formated "01" as key and
         * total as regular number value.  
         */
        $monthlyOrderTotal = $orders->groupBy( function($date){ return Carbon::parse($date->order_date)->format('m'); })
                ->map(function ($item) { return $item->sum('order_total'); });

        $monthlyInvoiceTotal = $invoices->groupBy( function($date){ return Carbon::parse($date->invoice_date)->format('m'); })
                ->map(function ($item) { return $item->sum('invoice_total'); });

        $monthlyCollectionTotal = $collections->groupBy( function($date){ return Carbon::parse($date->mr_date)->format('m'); })
                ->map(function ($item) { return $item->sum('amount'); });

        foreach ($monthlyOrderTotal as $key => $value){
            $mot->add(['month' => $key, 'total' => $value]);
        }
        
        foreach ($monthlyInvoiceTotal as $key => $value){
            $mit->add(['month' => $key, 'total' => $value]);
        }
        
        foreach ($monthlyCollectionTotal as $key => $value){
            $mct->add(['month' => $key, 'total' => $value]);
        }
        
        foreach ($monthArr as $key => $value){
            if(!in_array($value, $mot->pluck('month')->toArray()))
            {
                $mot->add(['month' => $value, 'total' => 0]);
            }
            
            if(!in_array($value, $mit->pluck('month')->toArray()))
            {
                $mit->add(['month' => $value, 'total' => 0]);
            }
            
            if(!in_array($value, $mct->pluck('month')->toArray()))
            {
                $mct->add(['month' => $value, 'total' => 0]);
            }
        }
        
        $oData = $mot->sortBy('month')->pluck('total');
        $iData = $mit->sortBy('month')->pluck('total');
        $cData = $mct->sortBy('month')->pluck('total');
  
        //return response()->json($invoices);
        
        return response()->json(['mot' => $oData, 'mit' => $iData, 'mct' => $cData]);
        
    }
    

    /*
    * Donut Chart Data function
    */
    public function getPieChartData() 
    {
        $colors = ['#1abc9c', '#16a085', '#2ecc71', '#27ae60', '#3498db', '#2980b9', '#f1c40f', '#f39c12', '#e67e22', '#d35400', '#e74c3c', '#c0392b', '#95a5a6', '#7f8c8d'  ];
        $ip = DB::table('invoice_product')
                ->selectRaw('product_id,item_name, sum(item_total) as total')
                ->groupBy('product_id', 'item_name')
                ->orderBy('total','desc')
                ->get();
        foreach($ip as $p)
        {
            $p->color = Arr::random($colors);
        }
        $labels = $ip->pluck('item_name');
        $data = $ip->pluck('total');
        $color = $ip->pluck('color');
        
        //return dd($ip);
        return response()->json(['labels' => $labels, 'data' => $data, 'color' => $color]);
    }
    
    
    /*
     * @return $result collection.
     */
    public function projectCardData()
    {
        $result = collect();
        $products = Product::all();
        foreach($products as $product)
        {
            $c = collect(['name' => $product->name, 'percentage' => $product->itemStockPercent()]) ;
            $result->add($c);
        }
        return $result;
    }
}
