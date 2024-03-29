<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderFormRequest;
use App\User as Buyer;
use App\Product;
use App\Order;
use App\Role;
use App\Contact;
use App\Address;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;
use NumberFormatter;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;

class SampleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
          if ($request->ajax()) {
            return DataTables::of(Order::query()->where('order_type', config('constants.order_type.sample'))->get())
                ->addColumn('order_no', function($row) {
                    return '<small>'.
                                '<a class="text-success" href="'.route('samples.show', $row->id).'" ><i class="fas fa-eye fa-lg"></i></a>'.' '.
                                '<a class="text-warning edit" href="'.$row->id.'"><i class="fas fa-edit fa-lg"></i></a>'.' '.
                                '<a class="text-danger delete" href="'.$row->id.'"><i class="fas fa-trash-alt fa-lg"></i></a>'.' '.
                            '</small>'.
                            strtoupper($row->order_no);
                })
                ->addColumn('order_date', function($row) {
                    return !empty($row->order_date) ? Carbon::create($row->order_date)->toFormattedDateString() : "";
                })
                ->addColumn('customer_name', function($row) {
                    return $row->customer_name.'<br><strong>'.$row->customer_company.'</strong>';
                })
                ->addColumn('quantity_type', function($row) {
                    return empty($row->quantity_type) ? "Packing" : ucfirst($row->quantity_type) ;
                })
                ->addColumn('order_total', function($row) {
                    return 'Tk. '.number_format($row->order_total,2);
                })
                ->addColumn('is_invoiced', function($row) {
                    return $row->is_invoiced ? 'Yes' : '<a class="text-warning invoice" href="' .route('create.invoice',$row->id).'"><i class="fas fa-file-invoice-dollar fa-lg"></i> No </a> ';
                })
                ->addColumn('order_status', function($row) {
                    return ucfirst($row->order_status);
                })
                ->rawColumns(['customer_name', 'is_invoiced'])
                ->make(true);
        } else {
            return view("admin.samples.index");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $buyers = Buyer::whereHas('roles', function($q){
            $q->whereIn('name',[config('constants.roles.client'),config('constants.roles.lead')]);
        })->where('is_active',true)->orderBy('name','asc')->get();       
        $products = Product::all();
        if (!empty($buyers)) {
            return response()->json(['buyers' => $buyers, 'products' => $products]);
        } else {
            return response()->json(['error' => 'No supplier registered to system.']);
        }
    }
    
    /*
     * Ajax address fetcher
     */
    public function getAddress(Request $request) 
    {
        $buyer = Buyer::findOrFail($request->id);
        $address = $buyer->addresses;
        //$contacts = $buyer->contacts()->where('is_billing', true)->get();
        $contacts = $buyer->contacts()->get();
        return response()->json(['buyer' => $buyer, 'address' => $address, 'contacts' => $contacts ]);
    }
    
    /*
     * Ajax order fetcher
     */
    public function getOrder(Request $request) 
    {
        $order = Order::findOrFail($request->id);
        $order->unformated_order_date = $order->getRawOriginal('order_date');
        $order->products;
        return response()->json(['order' => $order ]);
    }
    
    /*
     * Packing receiver codes.
     * This function/method helps to get packing of products:
     */
    public function getPacking($productId, $quantityType, $quantity) 
    {
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
    
    /*
     * Ajax order fecher for Invoice.
     */
    public function getOrderForInvoice(Request $request) 
    {
        $order = Order::findOrFail($request->id);
        $order->unformated_order_date = $order->getOriginal('order_date');
        $order->products;
        !empty($order->quantity_type) ? $quantityType = $order->quantity_type : $quantityType = 'packing';
        if(count($order->invoices) > 0){
            $invoice_ids = $order->invoices()->pluck('id')->toArray();
            $invoiced = DB::table('invoice_product')
                    ->select('product_id', DB::raw('sum(item_qty) as qty'), DB::raw('sum(item_total) as price') )
                    ->whereIn('invoice_id', $invoice_ids)
                    ->groupBy('product_id')->get();
            
            foreach($order->products as $item) { 
                $invoiced_qty = $invoiced->where('product_id', $item->pivot->product_id)->pluck('qty')->first();
                $invoiced_price = $invoiced->where('product_id', $item->pivot->product_id)->pluck('price')->first();
                $item->pivot->quantity = ($item->pivot->quantity - $invoiced_qty); 
                $item->pivot->product_packing = $this->getPacking($item->pivot->product_id, $quantityType, $item->pivot->quantity);
                $item->pivot->item_total = ($item->pivot->item_total - $invoiced_price); 
            }
        }
        return response()->json(['order' => $order ]);
    }
    
    /*
     * Ajax order fecher for Challan.
     */
    public function getOrderForChallan(Request $request) 
    {
        $order = Order::findOrFail($request->id);
        $order->unformated_order_date = $order->getOriginal('order_date');
        $order->products;
        if(count($order->challans) > 0){
            $challan_ids = $order->challans()->pluck('id')->toArray();
            $challan_issued = DB::table('challan_product')->select('product_id', DB::raw('sum(quantity) as qty') )->whereIn('challan_id', $challan_ids)->groupBy('product_id')->get();
            
            foreach($order->products as $item) { 
                $challan_qty = $challan_issued->where('product_id', $item->pivot->product_id)->pluck('qty')->first();
                $item->pivot->quantity = ($item->pivot->quantity - $challan_qty); 
            }
        }
        return response()->json(['order' => $order ]);
    }
    
    /*
     * Ajax product fetcher
     */
    public function getProducts(Request $request)
    {
        //get all products
        $products = Product::all();
        if ($request->ajax()) {
            foreach ($products as $item){
                $price = $item->itemStock($request->quantity_type)['price'].'&#47;'.$item->itemStock($request->quantity_type)['unit'];
                $stock = $item->itemStock($request->quantity_type)['qty']." ".$item->itemStock($request->quantity_type)['unit'];
                $items[] = ['id'=>$item->id, 'name'=>$item->name, 'price'=>$price, 'stock'=>$stock];
            }
            $data['items'] = $items;
            return json_encode($data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderFormRequest $request)
    {
        $order = new Order();
        $order->order_no = $request->order_no;
        $order->order_date = $request->order_date;
        $request->has('user_id') ? $order->user_id = $request->user_id : "";
        //Create user if not exist:
        if($request->has('user_id'))
        {
            $customer = Buyer::findOrFail($request->user_id);
        }
        else 
        {
            //Create customer
            $customer = Buyer::create([ 
                'name'=> $request->customer_name, 
                'organization' => $request->customer_company,
                'password' => "",
            ]); 
            //Find role
            $role = Role::whereIn('name',['Customer', 'Buyer','Client'])->first();
            //Save role for customer
            $customer->role()->save($role);
            //Create address
            $address = Address::create([ 'address' => $request->customer_address ]);
            //Save address for customer
            $customer->addresses()->save($address);
            //Save Contact
            $contact = Contact::create([ 'number' => $request->contact_no ]);
            $customer->contacts()->save( $contact );
        }
        $order->user_id = $customer->id;
        $order->customer_name = $customer->name;
        if($request->has('select-customer'))
        {
            $order->customer_company = $request->select_customer_company;
            $order->customer_address = $request->select_customer_address;
            $order->customer_contact = $request->select_customer_contact;
        } 
        else 
        {
            $order->customer_company = $request->customer_company;
            $order->customer_address = $request->customer_address;
            $order->customer_contact = $request->contact_no;
        }
        $order->shipp_to_name = $request->customer_name_shipping;
        $order->shipp_to_company = $request->shipping_company;
        $order->shipping_address = $request->shipping_address;
        $order->shipping_contact = $request->shipping_contact;
        $order->quantity_type = $request->quantity_type;
        $order->order_total = $request->total;
        $order->is_invoiced = false;
        $order->order_status = 'pending';
        $order->order_type = config('constants.order_type.sample');
        
        $order->save();
        //Loop through the rest to attach
        for ($i = 0; $i < count($request['product_ids']); $i++) {
            $product = Product::findOrFail($request['product_ids'][$i]);
            if($order->quantity_type == null ){ 
                $packing =  $product->packings()->first()->name.", "
                            .$product->packings()->first()->quantity
                            .$product->units()->first()->short." x "
                            .$product->packings()->first()->multiplier;
            }
            if($order->quantity_type == "pcs"){ 
                $packing =  $product->packings()->first()->quantity
                            .$product->units()->first()->short." x 1";
            }
            if($order->quantity_type == "weight"){ 
                $packing =  $product->packings()->first()->quantity
                            .$product->units()->first()->short." x "
                            .($request['quantities'][$i] / $product->packings()->first()->quantity);
            }
            $order->products()->attach($request['product_ids'][$i],
                [
                    'quantity' => $request['quantities'][$i],
                    'unit_price' => $request['unit_prices'][$i],
                    'item_total' => $request['item_totals'][$i],
                    'product_name' => Product::findOrFail($request['product_ids'][$i])->name,
                    'product_packing' => $packing
                ]);
        }
        return response()->json(['success' => 'Sample registered', 'request' => $request->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get order by id
        $order = Order::findOrFail($id);
        return view('admin.samples.show', compact('order'));
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
    public function update(OrderFormRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->order_no = $request->order_no;
        $order->order_date = $request->order_date;
        //$request->has('user_id') ? $order->user_id = $request->user_id : "";
        
        //Create user if not exist:
        if($request->has('user_id'))
        {
            $customer = Buyer::findOrFail($request->user_id);
        }
        else 
        {
            //Create customer
            $customer = Buyer::create([ 
                'name'=> $request->customer_name, 
                'organization' => $request->customer_company,
                'password' => "",
            ]); 
            //Find role
            $role = Role::whereIn('name',['Customer', 'Buyer','Client'])->first();
            //Save role for customer
            $customer->role()->save($role);
            //Create address
            $address = Address::create([ 'address' => $request->customer_address ]);
            //Save address for customer
            $customer->addresses()->save($address);
            //Save Contact
            $contact = Contact::create([ 'number' => $request->contact_no ]);
            $customer->contacts()->save( $contact );
        }
        
        //$request->has('customer_name') ? $order->customer_name = $request->customer_name : $order->customer_name = Buyer::findOrFail($request->user_id)->name;
        $order->user_id = $customer->id;
        $order->customer_name = $customer->name;
        if($request->has('select-customer'))
        {
            $order->customer_company = $request->select_customer_company;
            $order->customer_address = $request->select_customer_address;
            $order->customer_contact = $request->select_customer_contact;
        } 
        else 
        {
            $order->customer_company = $request->customer_company;
            $order->customer_address = $request->customer_address;
            $order->customer_contact = $request->contact_no;
        }
        $order->shipp_to_name = $request->customer_name_shipping;
        $order->shipp_to_company = $request->shipping_company;
        $order->shipping_address = $request->shipping_address;
        $order->shipping_contact = $request->shipping_contact;
        $order->quantity_type = $request->quantity_type;
        $order->order_total = $request->total;
        //Check if order is under processing:
        if($order->invoices()->count() > 0 OR $order->challans()->count() > 0)
        {$order->order_status = 'processing';} else {$order->order_status = 'pending';}
        $order->invoices()->count() > 0 ? $order->is_invoiced = true : $order->is_invoiced = false;
        
        $order->update();
        
        if( $order->products->count() > 0 ){
            $order->products()->detach();
        }
        //Loop through the rest to attach
        for ($i = 0; $i < count($request['product_ids']); $i++) {
            $product = Product::findOrFail($request['product_ids'][$i]);
            if($order->quantity_type == null ){ 
                $packing =  $product->packings()->first()->name.", "
                            .$product->packings()->first()->quantity
                            .$product->units()->first()->short." x "
                            .$product->packings()->first()->multiplier;
            }
            if($order->quantity_type == "pcs"){ 
                $packing =  $product->packings()->first()->quantity
                            .$product->units()->first()->short." x 1";
            }
            if($order->quantity_type == "weight"){ 
                $packing =  $product->packings()->first()->quantity
                            .$product->units()->first()->short." x "
                            .($request['quantities'][$i] / $product->packings()->first()->quantity);
            }
            $order->products()->attach(
                $request['product_ids'][$i],
                [
                    'quantity' => $request['quantities'][$i],
                    'unit_price' => $request['unit_prices'][$i],
                    'item_total' => $request['item_totals'][$i],
                    'product_name' => Product::findOrFail($request['product_ids'][$i])->name,
                    'product_packing' => $packing
                ]);
        }
        
        return response()->json(['success' => 'Order Updated', 'request' => $request->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        
        if($order->invoices()->count() > 0 OR $order->challans()->count() > 0)
        {
            return response()->json([
                'status' => false,
                'message' => "Sorry!!! Order is under processing. Delete all invoices and challans related to this order before performing this action."
            ]);
        } 
        else 
        {
            $order_no = $order->order_no;
            $order->products()->detach();
            $order->delete();
            return response()->json([
                'status' => true,
                'order' => $order_no,
                'message' => "Success!!! Order ".$order_no." has been deleted."
            ]);
        }
    }
    
    /*
     * For printing:
     */
    public function pdf(Request $request)
    {
        //return $request;
        $order = Order::findOrFail($request->id);
        $inwords = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $order->inwords = $inwords->format($order->order_total);
        $pdf = PDF::loadView('admin.order.print', compact('order'))->setPaper('a4', 'portrait');
        $fileName = 'order_'.$order->order_no;
        return $pdf->stream($fileName.'.pdf');
    }
    
    /*
     * Unique Reference Generator:
     */
    public function getUniqueRefNo() {
        //Generate Unique Reference No:
        $config = [
            'table' => 'orders',
            'field' => 'order_no',
            'length' => 17,
            'prefix' => 'vsf/'.date('y/m').'/smp-',
            'reset_on_prefix_change' => true
        ];
        $id = IdGenerator::generate($config);
        return Str::upper($id);
    }
    
    
    
}
