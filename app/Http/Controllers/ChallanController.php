<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChallanFormRequest;
use App\Store;
use App\Order;
use App\User;
use App\Challan;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PDF;

class ChallanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Challan::query()->where('challan_type', 1)->get())
                ->addColumn('challan_no', function($row) {
                    return '<small><a class="text-success" href="'.route('challans.show',$row->id).'" target="_blank"><i class="fas fa-eye fa-lg"></i></a> '.
                            '<a class="text-danger delete" href="'.$row->id.'"><i class="fas fa-trash-alt fa-lg"></i></a></small> ' .
                            strtoupper($row->challan_no);
                })
                ->addColumn('challan_date', function($row) {
                    return !empty($row->challan_date) ? Carbon::create($row->challan_date)->toFormattedDateString() : "";
                })
                ->addColumn('customer_name', function($row) {
                    return !empty($row->customer_name) ? Str::limit($row->customer_name, 50) : 'Unregistered';
                    //return Str::limit($row->customer_name, 50);
                })
                ->addColumn('transfer_items', function($row) {
                    $trItems = implode(', ', $row->products->pluck('name')->toArray());
                    return $trItems;
                })
                ->addColumn('quantity_type', function($row) {
                    return ucfirst($row->quantity_type);
                })
                ->addColumn('store_name', function($row) {
                    return $row->store_name;
                })
                ->rawColumns(['challan_no', 'customer_name'])
                ->make(true);
        } else {
            return view("admin.challan.index");
        }
    }
    
    /**
     * Display a listing of the resource for a specific Order.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByOrder(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Challan::query()->where('order_id',$request->order_id)->get())
                ->addColumn('challan_no', function($row) {
                    return '<small><a class="text-success" href="'.route('challans.show',$row->id).'" target="_blank"><i class="fas fa-eye fa-lg"></i></a> '.
                            '<a class="text-danger delete" href="'.$row->id.'"><i class="fas fa-trash-alt fa-lg"></i></a></small> ' .
                            strtoupper($row->challan_no);
                })
                ->addColumn('challan_date', function($row) {
                    return !empty($row->challan_date) ? Carbon::create($row->challan_date)->toFormattedDateString() : "";
                })
                ->addColumn('customer_name', function($row) {
                    return !empty($row->customer_name) ? Str::limit($row->customer_name, 50) : 'Unregistered';
                    //return Str::limit($row->customer_name, 50);
                })
                ->addColumn('transfer_items', function($row) {
                    $trItems = implode(', ', $row->products->pluck('name')->toArray());
                    return $trItems;
                })
                ->addColumn('quantity_type', function($row) {
                    return ucfirst($row->quantity_type);
                })
                ->addColumn('store_name', function($row) {
                    return $row->store_name;
                })
                ->rawColumns(['challan_no', 'customer_name'])
                ->make(true);
        }
        
    }
    
    
    /**
     * Display a listing of Transfer Challan.
     *
     * @return \Illuminate\Http\Response
     */
    public function trchIndex(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Challan::query()->where('challan_type', 2)->get())
                ->addColumn('challan_no', function($row) {
                    return '<small><a class="text-success" href="'.route('challans.show',$row->id).'" target="_blank"><i class="fas fa-eye fa-lg"></i></a> '.
                            '<a class="text-danger delete" href="'.$row->id.'"><i class="fas fa-trash-alt fa-lg"></i></a></small> ' .
                            strtoupper($row->challan_no);
                })
                ->addColumn('challan_date', function($row) {
                    return !empty($row->challan_date) ? Carbon::create($row->challan_date)->toFormattedDateString() : "";
                })
                ->addColumn('store_name', function($row) {
                    return $row->store_name;
                })
                ->addColumn('to_store_name', function($row) {
                    return ucfirst($row->to_store_name);
                })
                ->addColumn('transfer_items', function($row) {
                    $trItems = implode(', ', $row->products->pluck('name')->toArray());
                    return $trItems;
                })
                ->rawColumns(['challan_no'])
                ->make(true);
        } else {
            return view("admin.challan.trchindex");
        }
    }
    
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //Get Stores
        $stores = Store::all();
        $order = Order::findOrFail($id);
        return view("admin.challan.create", compact('order','stores'));
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function transfer()
    {
        //Get Stores
        $stores = Store::all();
        return view("admin.challan.transfer", compact('stores'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChallanFormRequest $request)
    {
        $store = Store::findOrFail($request->supply_store);
        if($request->challan_type == 1){
            //Check if customer is registered.
            if(!empty($request->customer_id)){
                $customerId = $request->customer_id;
                $customerName = User::findOrFail($request->customer_id)->name;
            } else {
                $customerId = null;
                $customerName = null;
            }
            $challan = Challan::create([
                'challan_date' => $request->challan_date,
                'challan_no' => $request->challan_no,
                'challan_type' => $request->challan_type,
                'order_id' => $request->order_id,
                'order_no' => $request->order_no,
                'quantity_type' => $request->q_type,
                'store_id' => $request->supply_store,
                'store_name' => $store->name,
                'store_address' =>$store->address,
                'customer_id' => $customerId,
                'customer_name' => $customerName,
                'delivery_address' => $request->delivery_to
            ]);
            if($challan){
                //Loop through items to attach in challan details and stock table:
                for($i=0; $i < count($request['item_id']); $i++){
                    $challan->products()->attach($request['item_id'][$i],
                            [
                                'item_name' => $request['item_name'][$i], 
                                'item_unit' => $request['item_unit'][$i], 
                                'quantity' => $request['item_qty'][$i]
                            ]);
                }
            }
            //Change stock:
            foreach($challan->products as $product){
                $challan->stock()->attach($product->id, 
                        [
                            'quantity' => $product->productCountNormalizer($request->q_type, $product->pivot->quantity), 
                            'store_id' => $request->supply_store, 
                            'flag' => 'out'
                        ]);
            }
            //Change order status:
            $order = Order::findOrFail($request->order_id);
            if($order->isComplete()){
                $order->update(['order_status' => 'complete']);
            }           
        }
        return response()->json(['success' => 'Challan stored', 'request' => $request->all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTransfer(ChallanFormRequest $request)
    {
        
        $from_store = Store::findOrFail($request->from_store);
        $to_store = Store::findOrFail($request->to_store);
        if($request->challan_type == 2){
            $challan = Challan::create([
                'challan_date' => $request->challan_date,
                'challan_no' => $request->challan_no,
                'challan_type' => $request->challan_type,
                'quantity_type' => 'packing',
                'store_id' => $request->from_store,
                'store_name' => $from_store->name,
                'store_address' => $from_store->address,
                'to_store_id' => $request->to_store, 
                'to_store_name' => $to_store->name, 
                'to_store_address' => $to_store->address, 
            ]);
            if($challan){
                //Loop through items to attach in challan details and stock table:
                for($i=0; $i < count($request['item_id']); $i++){
                    $challan->products()->attach($request['item_id'][$i],
                            [
                                'item_name' => $request['item_name'][$i], 
                                'item_unit' => $request['item_unit'][$i], 
                                'quantity' => $request['item_qty'][$i]
                            ]);
                }
            }
            //Stock out by Challan:
            foreach($challan->products as $product){
                $challan->stock()->attach($product->id, 
                        [
                            'quantity' => $product->productCountNormalizer('', $product->pivot->quantity), 
                            'store_id' => $request->from_store, 
                            'flag' => 'out'
                        ]);
            }
            //Stock in by Challan:
            foreach($challan->products as $product){
                $challan->stock()->attach($product->id, 
                        [
                            'quantity' => $product->productCountNormalizer('', $product->pivot->quantity), 
                            'store_id' => $request->to_store, 
                            'flag' => 'in'
                        ]);
            }

        }


        return response()->json(['success' => 'Challan stored', 'request' => $request->all()]);
    }
    
    
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $challan = Challan::findOrFail($id);
        $challan->products;
        return view("admin.challan.show", compact('challan'));
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
        //find purchase by id:
        $challan = Challan::findOrFail($id);
        $challan_type = $challan->challan_type;
        //find order related to this challan
        $order = $challan->order;
        //Detach all Purchase items from PIVOT:
        $challan->products()->detach();
        //Detach all stocks from PIVOT:
        $challan->stock()->detach();
        //Finally delete purchase:
        $challan->delete();
        //If Challan is a Delivery Challan change Order status:
        if($challan_type == 1){
            if($order->isComplete()){
                $order->update(['order_status' => 'complete']);
            } else {
                if($order->isInvoiced()){
                    $order->update(['order_status' => 'processing']);
                } else {
                    $order->update(['order_status' => 'pending']);
                }
            }
        }
        
        return response()->json(['success' => 'Item has been destroyed.', 'challan'=> $challan->challan_no ]);
    }
    
    
    /*
     * For printing:
     */
    public function pdf(Request $request)
    {
        //return $request;
        $challan = Challan::findOrFail($request->id);
        $challan->products;
        $pdf = PDF::loadView('admin.challan.print', compact('challan'))->setPaper('a4', 'portrait');
        $fileName = 'challan_'.$challan->challan_no;
        return $pdf->stream($fileName.'.pdf');
    }
    
}
