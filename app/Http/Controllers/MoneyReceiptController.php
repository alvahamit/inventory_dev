<?php

namespace App\Http\Controllers;

use App\MoneyReceipt as Mr;
use App\User as Customer;
use Illuminate\Http\Request;
use App\Http\Requests\MrFormRequest;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;
use NumberFormatter;
use PDF;

class MoneyReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = Customer::whereHas('roles', function($q){
            $q->where('name',config('constants.roles.client')); 
        })->orderBy('id','desc')->get();
        $data = Mr::query();
        $data->latest()->first() ? $lastUpdated = $data->latest()->first()->updated_at->diffForHumans() : $lastUpdated = "never";
        $data = Mr::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('mr_no', function($row) {
                    return '<small>'.
                                '<a class="text-success" href="'.route('mrs.show',$row->id).'" target="_blank"><i class="fas fa-eye fa-lg"></i></a> '.
                                '<a class="text-warning edit" href="'.$row->id.'"><i class="fas fa-edit fa-lg"></i></a>'.
                                '<a class="text-danger delete" href="'.$row->id.'"><i class="fas fa-trash-alt fa-lg"></i></a>'.
                            '</small> '.
                            strtoupper($row->mr_no);
                })
                ->addColumn('mr_date', function($row) {
                    return !empty($row->mr_date) ? Carbon::create($row->mr_date)->toFormattedDateString() : "";
                })
                ->addColumn('customer_name', function($row) {
                    return !empty($row->customer_name) ? Str::limit($row->customer_name, 50) : 'Unregistered';
                    //return Str::limit($row->customer_name, 50);
                })
                ->addColumn('customer_company', function($row) {
                    return $row->customer_company;
                })
                ->addColumn('amount', function($row) {
                    return 'Tk. '.number_format($row->amount,2);
                })
                ->addColumn('pay_mode', function($row) {
                    return $row->pay_mode;
                })
                ->rawColumns(['mr_no', 'customer_name'])
                ->make(true);
        } else {
            return view("admin.moneyreceipt.index", compact('customers','lastUpdated'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /*
     * Helper funciton:
     * This converts paymode number to name to store in DB.
     */
    public function payModeName(int $id) 
    {
        switch ($id) {
            case 1:
              $payMode = 'cash';
              break;
            case 2:
              $payMode = 'cheque';
              break;
            case 3:
              $payMode = 'bkash';
              break;
            default:
              $payMode = 'cash';
        }
        return $payMode;
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MrFormRequest $request)
    {
        //Store MR
        $mr = Mr::create([
            'mr_date' => $request->mr_date,
            'mr_no'=> $request->mr_no,
            'customer_id' => $request->customer_id,
            'customer_name' => $request->customer_name,
            'customer_company' => $request->customer_company,
            'customer_address' => $request->customer_address,
            'customer_phone' => $request->customer_phone,
            'customer_email'=> $request->customer_email,
            'amount' => $request->amount,
            'pay_mode' => $this->payModeName($request->payModeChooser),
            'cheque_no' => $request->cheque_no,
            'bank_name'=> $request->bank_name,
            'bkash_tr_no'=> $request->bkash_tr_no
        ]);
        return response()->json(['success' => 'MR stored', 'request' => $request->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MoneyReceipt  $moneyReceipt
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mr = Mr::findOrFail($id);
        $inwords = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $mr->inwords = $inwords->format($mr->amount);
        return view("admin.moneyreceipt.show", compact('mr'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param  \App\MoneyReceipt  $moneyReceipt
     * @return \Illuminate\Http\Response
     */
    public function edit(MoneyReceipt $moneyReceipt)
    {
        //
    }
    
    public function getMr(Request $request)
    {
        $mr = Mr::findOrFail($request->id);
        $mr->unformated_mr_date = $mr->getRawOriginal('mr_date');
        return response()->json(['mr' => $mr]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MoneyReceipt  $moneyReceipt
     * @return \Illuminate\Http\Response
     */
    public function update(MrFormRequest $request, $id)
    {
        // Merge new element to request:
        $pay_mode = $this->payModeName($request->payModeChooser);
        $request->merge(['pay_mode' => $pay_mode]);
        //Find MR
        $mr = Mr::findOrFail($id);
        $mr->update( $request->except('inputChooser', 'payModeChooser') );
        return response()->json(['success' => 'MR Updated', 'request' => $request->except('inputChooser', 'payModeChooser') ,'mr' => $mr]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MoneyReceipt  $moneyReceipt
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $mr = Mr::findOrFail($id);
        $mr_no = $mr->mr_no; 
        $amount = $mr->amount;
        $mr->delete();
        //return response()->json(['success'=> 'MR deleted','mr_no' => $mr_no]);
        return response()->json([
            'status'=> true,
            'mr_no' => $mr_no,
            'message' => "Success!!! Money receipt ".$mr_no.", with amount of Tk. ".$amount." has been deleted."
        ]);
    }
    
    
    /*
     * For printing:
     */
    public function pdf(Request $request)
    {
        //return $request;
        $mr = Mr::findOrFail($request->id);
        $inwords = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $mr->inwords = $inwords->format($mr->amount);
        $pdf = PDF::loadView('admin.moneyreceipt.print', compact('mr'))->setPaper('a4', 'portrait');
        $fileName = 'mr_'.$mr->mr_no;
        return $pdf->stream($fileName.'.pdf');
    }
    
}
