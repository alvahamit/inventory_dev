<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MoneyReceipt as Mr;
use App\User as Customer;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;
use NumberFormatter;

class CustomerAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = Customer::whereHas('role', function($q){
            $q->whereIn('name',['Buyer', 'Customer', 'Client']); 
        })->orderBy('id','desc')->get();
        
        if ($request->ajax()) {
            $datatable = DataTables::of($customers)
                ->addColumn('name', function($row) {
                    return $row->name;
                })
                ->addColumn('company', function($row){
                    return $row->organization;
                })
                ->addColumn('orders', function($row){
                    return $row->orders()->count();
                })
                ->addColumn('orders_amt', function($row){
                    return 'Tk. '.number_format($row->orders()->sum('order_total'),2);
                })
                ->addColumn('invoiced', function($row){
                    return $row->invoices()->count();
                })
                ->addColumn('invoice_amt', function($row){
                    return 'Tk. '.number_format($row->invoices()->sum('invoice_total'),2);
                })
                ->addColumn('received_amt', function($row){
                    return 'Tk. '.number_format($row->mrs()->sum('amount'),2);
                })
                ->addColumn('completes', function($row){
                    return $row->orders()->whereOrderStatus('complete')->count();
                })
                ->rawColumns(['name'])
                ->make(true);
            return $datatable;    
        } else {
            return view("admin.custacc.index");
        }
        
    }
}
