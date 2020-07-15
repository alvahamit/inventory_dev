<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InvoiceFormRequest;
use App\Order;
use App\Invoice;
use App\Product;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PDF;
use NumberFormatter;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Invoice::query()->get())
                ->addColumn('invoice_no', function($row) {
                    return '<small><a class="text-success" href="' .
                            route('invoices.show',$row->id) .
                            '" target="_blank"><i class="fas fa-eye fa-lg"></i></a> ' .
                            '<a class="text-warning edit" href="' .
                            $row->id .
                            '"><i class="fas fa-edit fa-lg"></i></a> <a class="text-danger delete" href="'.
                            $row->id.
                            '"><i class="fas fa-trash-alt fa-lg"></i></a></small> ' .
                            strtoupper($row->invoice_no);
                })
                ->addColumn('invoice_date', function($row) {
                    return !empty($row->invoice_date) ? Carbon::create($row->invoice_date)->toFormattedDateString() : "";
                })
                ->addColumn('billed_to', function($row) {
                    return Str::limit($row->billed_to, 35);
                })
                ->addColumn('quantity_type', function($row) {
                    return ucfirst($row->quantity_type);
                })
                ->addColumn('invoice_total', function($row) {
                    return 'Tk. '.number_format($row->invoice_total,2);
                })
                ->addColumn('invoice_type', function($row) {
                    return $row->invoice_type =="1" ? 'Whole' : 'Partial';
                })
                ->rawColumns(['invoice_no', 'billed_to'])
                ->make(true);
        } else {
            return view('admin.invoice.index');
        }
        
    }

    
    /**
     * Display a listing of the resource for a specific Order.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByOrder(Request $request)
    {
        //return response()->json(['request' => $request->all()]);
         
        if ($request->ajax()) {
            return DataTables::of(Invoice::query()->where('order_id',$request->order_id)->get())
                ->addColumn('invoice_no', function($row) {
                    return '<small><a class="text-success" href="'.route('invoices.show',$row->id).'" target="_blank"><i class="fas fa-eye fa-lg"></i></a> '.
                            '<a class="text-danger delete" href="'.$row->id.'"><i class="fas fa-trash-alt fa-lg"></i></a></small> ' .
                            strtoupper($row->invoice_no);
                })
                ->addColumn('invoice_date', function($row) {
                    return !empty($row->invoice_date) ? Carbon::create($row->invoice_date)->toFormattedDateString() : "";
                })
                ->addColumn('billed_to', function($row) {
                    return Str::limit($row->billed_to, 50);
                })
                ->addColumn('quantity_type', function($row) {
                    return ucfirst($row->quantity_type);
                })
                ->addColumn('invoice_total', function($row) {
                    return 'Tk. '.number_format($row->invoice_total,2);
                })
                ->addColumn('invoice_type', function($row) {
                    return $row->invoice_type =="1" ? 'Whole' : 'Partial';
                })
                ->rawColumns(['invoice_no', 'billed_to'])
                ->make(true);
        }
        
    }
    
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.invoice.create', compact('order'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceFormRequest $request)
    {
        $invoice = Invoice::create([
            'invoice_date' => $request->invoice_date,
            'invoice_no' => $request->invoice_no,
            'order_id' => $request->order_id,
            'order_no' => $request->order_no,
            'quantity_type' => $request->q_type,
            'invoice_type' => $request->invoice_type,
            'invoiced_by'=> $request->invoiced_by,
            'customer_id'=> $request->customer_id,
            'billed_to' => $request->billed_to,
            'discount' => $request->discount,
            'carrying' => $request->carrying,
            'other_charge' => $request->other_charge,
            'invoice_total' => $request->total
        ]);
        if($invoice){
            //Loop through the rest to attach
            for ($i = 0; $i < count($request['item_id']); $i++) {
                // Get packing.
                $packing = $this->getPacking($request['item_id'][$i], $invoice->quantity_type, $request['item_qty'][$i]);
                $invoice->products()->attach($request['item_id'][$i],
                [
                    'item_name' => $request['item_name'][$i],
                    //'item_unit' => $request['item_unit'][$i],
                    'item_unit' => $packing,
                    'unit_price' => $request['unit_price'][$i],
                    'item_qty' => $request['item_qty'][$i],
                    'item_total' => $request['item_total'][$i]
                ]);
            }
        }
            
        //Order::findOrFail($request->order_id)->update(['is_invoiced' => true,  'order_status' => 'processing',]);
        $order = Order::findOrFail($request->order_id);
        if($order->order_status == "pending"){
             $order->update(['order_status' => 'processing']);
        }
        if(!$order->is_invoiced){
             $order->update(['is_invoiced' => true]);
        }

        return response()->json(['success' => 'invoice stored', 'request' => $request->all()]);
    }

    /*
     * Packing receiver codes.
     * This function/method helps to get packing of products:
     */
    public function getPacking($productId, $quantityType, $quantity) {
        // Packing modifyer codes:
        $product = Product::findOrFail($productId);
        if($quantityType == 'packing' ){ 
            $packing =  $product->packings()->first()->name.", "
                        .$product->packings()->first()->quantity
                        .$product->units()->first()->short." x "
                        .$product->packings()->first()->multiplier;
        }
        if($quantityType == "pcs"){ 
            $packing =  $product->packings()->first()->quantity
                        .$product->units()->first()->short." x 1";
        }
        if($quantityType == "weight"){ 
            $packing =  $product->packings()->first()->quantity
                        .$product->units()->first()->short." x "
                        .($quantity / $product->packings()->first()->quantity);
        }
        return $packing;
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->products;
        return view('admin.invoice.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $order = $invoice->order;
        $invoice->products()->detach();
        $invoice->delete();
        if(count($order->invoices) == 0 ){
            count($order->challans) == 0 ? $status = "pending" : $status = "processing" ;
            $order->update(['is_invoiced' => false, 'order_status' => $status]);
        }
        return response()->json(['success' => 'Invoice deleted', 'invoice'=> $invoice->invoice_no ]);
    }
    
    /*
     * For printing:
     */
    public function pdf(Request $request)
    {
        //return $request;
        $invoice = Invoice::findOrFail($request->id);
        $inwords = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $invoice->inwords = $inwords->format($invoice->invoice_total);
        $pdf = PDF::loadView('admin.invoice.print', compact('invoice'))->setPaper('a4', 'portrait');
        $fileName = 'invoice_'.$invoice->invoice_no;
        return $pdf->stream($fileName.'.pdf');
    }
    
    
}
