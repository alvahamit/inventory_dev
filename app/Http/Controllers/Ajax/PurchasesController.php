<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PurchaseFormRequest;
use App\Purchase;
use App\User as Supplier;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PurchasesController extends Controller {

    //Ajax call to index
    public function index(Request $request) {
        if ($request->ajax()) {
            return DataTables::of(Purchase::query())
                ->addColumn('receive_date', function($row){
                    return !empty($row->receive_date) ? Carbon::create($row->receive_date)->toFormattedDateString() : "";
                })
                ->addColumn('supplier', function($row) {
                    return $row->user->name;
                })
                ->addColumn('total', function($row) {
                    return 'Tk. '.number_format($row->total,2);
                })
                //'Tk. '.number_format($row->total,2);
                ->addColumn('created_at', function($row) {
                    return !empty($row->created_at) ? $row->created_at->diffForHumans() : "";
                })
                ->addColumn('updated_at', function($row) {
                    return !empty($row->updated_at) ? $row->updated_at->diffForHumans() : "";
                })
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group">';
                    $btn = $btn.'<button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    $btn = $btn.'Action';
                    $btn = $btn.'</button>';
                    $btn = $btn.'<div class="dropdown-menu">';
                    $btn = $btn.'<a class="show dropdown-item" href="'.route('purchases.show', $row->id).'" target="_blank"><i class="fas fa-eye"></i> View</a>';
                    $btn = $btn.'<a class="edit dropdown-item" href="'.$row->id.'"><i class="fas fa-edit"></i> Edit</a>';
                    $btn = $btn.'<a class="del dropdown-item" href="'.$row->id.'"><i class="fas fa-trash-alt"></i> Delete</a>';
                    $btn = $btn.'<div class="dropdown-divider"></div>';
                    $btn = $btn.'<a class="pdf dropdown-item" href="'.$row->id.'"><i class="far fa-file-pdf"></i> PDF</a>';
                    $btn = $btn.'</div>';
                    $btn = $btn.'</div>';
                    return $btn;
                })
                ->rawColumns(['action'])    
                ->make(true);
        }
        //return view('admin.purchase.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        $ptypes = config('constants.purchase');
        $suppliers = Supplier::whereHas('roles', function($q) {
            $q->whereIn('name', [config('constants.roles.supplier'), config('constants.roles.exporter')]);
        })->where('is_active',true)->get();
        return response()->json(['ptypes'=>$ptypes, 'suppliers'=>$suppliers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SupplierAjaxFormRequest;  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseFormRequest $request) {
        $purchase = new Purchase();
        $purchase->ref_no = $request->ref_no;
        $purchase->receive_date = $request->receive_date;
        $purchase->user_id = $request->user_id;
        $purchase->purchase_type = $request->purchase_type;
        $purchase->total = $request->total;
        $purchase->save();
        //Loop through the reset to attach
        for ($i = 0; $i < count($request['product_ids']); $i++) {
            $purchase->products()->attach($request['product_ids'][$i],
                    [
                        'quantity' => $request['quantities'][$i],
                        'unit_price' => $request['unit_prices'][$i],
                        'item_total' => $request['item_totals'][$i],
                        'manufacture_date' => $request['manufacture_dates'][$i],
                        'expire_date' => $request['expire_dates'][$i]
                    ]);
            //Attach to Stocks concept table:
            $purchase->stock()->attach($request['product_ids'][$i],
                    [
                        'quantity' => $request['quantities'][$i], 
                        'store_id' => 1, 
                        'flag' => 'in'
                    ]);
        }
        return response()->json(['success' => 'Added new records.', 'request' => $request->all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //get purchase by id
        $purchase = Purchase::findOrFail($id);
        $items = $purchase->products;
        return response()->json(['purchase' => $purchase, 'items' => $items]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseFormRequest $request, $id) {
        //find purchase by id:
        $purchase = Purchase::findOrFail($id);
        $no_of_items = count($purchase->products);
        //Set new value for Purchase:
        $purchase->ref_no = $request->ref_no;
        $purchase->receive_date = $request->receive_date;
        $purchase->user_id = $request->user_id;
        $purchase->purchase_type = $request->purchase_type;
        $purchase->total = $request->total;
        $update = $purchase->update();
        //If Purchase main table is updated do PIVOT: 
        if($update){
            //if this purchase has items:
            if ($no_of_items > 0) 
            {
                //Detach all items from purchase details PIVOT: 
                $purchase->products()->detach(); 
                //Detach all previous stocks from PIVOT:
                $purchase->stock()->detach();
            }
            
            //Loop through this request to attach all items:
            for ($i = 0; $i < count($request['product_ids']); $i++) {
                $purchase->products()->attach($request['product_ids'][$i],
                    [
                        'quantity' => $request['quantities'][$i],
                        'unit_price' => $request['unit_prices'][$i],
                        'item_total' => $request['item_totals'][$i],
                        'manufacture_date' => $request['manufacture_dates'][$i],
                        'expire_date' => $request['expire_dates'][$i]
                    ]);
                //Attach to stocks concept table:
                $purchase->stock()->attach($request['product_ids'][$i],
                    [
                        'quantity' => $request['quantities'][$i], 
                        'store_id' => 1, 
                        'flag' => 'in'
                    ]);
            }
            //Touch Purchase
            $purchase->touch();
        }
        //Return some comprehensive response for debugging:
        return response()->json([
                    'success' => 'Records updated.',
                    'request' => $request->all(),
                    'status' => $update,
                    'no-of-items' => $no_of_items
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //find purchase by id:
        $purchase = Purchase::findOrFail($id);
        $result = true;
        foreach($purchase->products as $product)
        {
            $stockQty = $product->itemStock()['qty'];
            //return response()->json(['product' => $product->name,'stock' => $stockQty]);
            $purchQty = $product->pivot->quantity;
            //return response()->json(['product' => $product->name,'purchase qty' => $purchQty]);
            if(($stockQty - $purchQty) >= 0 ){
                $result = $result*true;
            } else {
                $result = $result*false;
            }
        }
        /*
         * Note: 
         * If stock of all items of this purchase calculates to 0 or more
         * $result will return "true" else $result will return "false".
         */
        if($result){
            //Detach all Purchase items from PIVOT:
            $purchase->products()->detach();
            //Detach all stocks from PIVOT:
            $purchase->stock()->detach();
            //Finally delete purchase:
            $purchase->delete();
            return response()->json([
                'status' =>true,
                'message' => 'Purchase '.$purchase->ref_no.' receive dated '.$purchase->receive_date.' deleted.'
            ]);
        } else {
            return response()->json([
                'status' =>false,
                'message' => 'Purchased items may have already been traded. Cannot deleted this purchase now.'
            ]);
        }
    }

}
