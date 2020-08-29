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
    
    /*
     * Customer Order vs Credit Amt.
     */
    public function custOrderVsCredit($id)
    {
        $cust = Customer::findOrFail($id);
        $orderTotal = $cust->orders()->sum('order_total');
        $paymentTotal = $cust->mrs()->sum('amount');
        $credit = $cust->credit_limit;
        return ($credit-($orderTotal-$paymentTotal));
    }
    
    /*
     * Customer Invoice vs Credit Amt.
     */
    public function custInvoiceVsCredit($id)
    {
        $cust = Customer::findOrFail($id);
        $invoiceTotal = $cust->invoices()->sum('invoice_total');
        $paymentTotal = $cust->mrs()->sum('amount');
        $credit = $cust->credit_limit;
        return ($credit-($invoiceTotal-$paymentTotal));
    }
    
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = Customer::whereHas('roles', function($q){
            $q->whereIn('name',[config('constants.roles.client')]); 
        })->orderBy('name','asc')->get();
        
        if ($request->ajax()) {
            $datatable = DataTables::of($customers)
                ->addIndexColumn()    
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
                ->addColumn('credit', function($row){
                    $difference = $this->custOrderVsCredit($row->id);
                    if($difference > 0){
                        return '<span class="text-success"><i class="fas fa-check-circle"></i> In Limit</span>';
                    } 
                    elseif($difference == 0){
                        return '<span class="text-warning"><i class="fas fa-exclamation-circle"></i> Exhausted</span>';
                    } 
                    else{
                        return '<span class="text-danger"><i class="fas fa-skull"></i> Overdue</span>';
                    }
                })
                ->addColumn('completes', function($row){
                    return $row->orders()->whereOrderStatus('complete')->count();
                })
                ->rawColumns(['name','credit'])
                ->make(true);
            return $datatable;    
        } else {
            return view("admin.custacc.index");
        }
        
    }
}
