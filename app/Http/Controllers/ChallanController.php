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
use Haruncpi\LaravelIdGenerator\IdGenerator;

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
            return DataTables::of(Challan::query()->where('challan_type', config('constants.challan_type.sales'))->get())
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
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group">';
                    $btn = $btn.'<button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    $btn = $btn.'Action';
                    $btn = $btn.'</button>';
                    $btn = $btn.'<div class="dropdown-menu">';
                    $btn = $btn.'<a class="show dropdown-item" href="'.route('challans.show', $row->id).'" target="_blank"><i class="fas fa-eye"></i> View</a>';
                    $btn = $btn.'<a class="edit dropdown-item" href="'.$row->id.'"><i class="fas fa-edit"></i> Edit</a>';
                    $btn = $btn.'<a class="del dropdown-item" href="'.$row->id.'"><i class="fas fa-trash-alt"></i> Delete</a>';
                    $btn = $btn.'<div class="dropdown-divider"></div>';
                    $btn = $btn.'<a class="pdf dropdown-item" href="'.$row->id.'"><i class="far fa-file-pdf"></i> PDF</a>';
                    $btn = $btn.'</div>';
                    $btn = $btn.'</div>';
                    return $btn;
                })
                ->rawColumns(['customer_name', 'action'])
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
     * Transfer Challan Index method.
     *
     * @return \Illuminate\Http\Response
     */
    public function transferChallanIndex(Request $request)
    {
        $data = Challan::query()->where('challan_type', config('constants.challan_type.transfer'));
        $data->latest()->first() ? $lastUpdated = $data->latest()->first()->updated_at->diffForHumans() : $lastUpdated = "never";
        
        if ($request->ajax()) {
            return DataTables::of(Challan::query()->where('challan_type', config('constants.challan_type.transfer'))->get())
//                ->addColumn('challan_no', function($row) {
//                    return '<small><a class="text-success" href="'.route('show.trch',$row->id).'" target="_blank"><i class="fas fa-eye fa-lg"></i></a> '.
//                            '<a class="text-danger delete" href="'.$row->id.'"><i class="fas fa-trash-alt fa-lg"></i></a></small> ' .
//                            strtoupper($row->challan_no);
//                })
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
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group">';
                    $btn = $btn.'<button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    $btn = $btn.'Action';
                    $btn = $btn.'</button>';
                    $btn = $btn.'<div class="dropdown-menu">';
                    $btn = $btn.'<a class="show dropdown-item" href="'.route('show.trch', $row->id).'" target="_blank"><i class="fas fa-eye"></i> View</a>';
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
        } else {
            return view("admin.challan.trchindex", compact('lastUpdated'));
        }
    }
    
    /**
     * Sample Challan Index method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sampleChallanIndex(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Challan::query()->where('challan_type', config('constants.challan_type.sample'))->get())
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
            return view("admin.challan.index_sample");
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
     * route('transfer.challan.create')
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
        $checkArray = [config('constants.challan_type.sales'), config('constants.challan_type.sample')];
        if( in_array($request->challan_type, $checkArray) )
        {
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
                'delivery_address' => $request->delivery_to,
                'issued_by' => auth()->user()->name
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
            } else {
                $order->update(['order_status' => 'processing']);
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
        if($request->challan_type == config('constants.challan_type.transfer')){
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
                'issued_by' => auth()->user()->name
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
        return response()->json([
            'status' => true,
            'message' => 'Transfer challan '.$challan->challan_no.' stored.'
        ]);
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
     * Display transfer challan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showtrch($id)
    {
        $challan = Challan::findOrFail($id);
        $challan->products;
        return view("admin.challan.showtrch", compact('challan'));
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
                if($order->isInvoiced() OR $order->issuedChalan()){
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
    
    
    /*
     * For printing trch:
     */
    public function pdftrch(Request $request)
    {
        //return $request;
        $challan = Challan::findOrFail($request->id);
        $challan->products;
        $pdf = PDF::loadView('admin.challan.printtrch', compact('challan'))->setPaper('a4', 'portrait');
        $fileName = 'trch_'.$challan->challan_no;
        return $pdf->stream($fileName.'.pdf');
    }
    
    
    /*
     * Unique Reference Generator:
     */
    public function getUniqueRefNo() {
        //Generate Unique Reference No:
        $config = [
            'table' => 'challans',
            'field' => 'challan_no',
            'length' => 17,
            'prefix' => 'vsf/'.date('y/m').'/cha-',
            'reset_on_prefix_change' => true
        ];
        $id = IdGenerator::generate($config);
        return Str::upper($id);
    }
    
}
