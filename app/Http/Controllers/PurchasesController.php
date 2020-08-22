<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Product;
use App\User as Supplier;
use App\Http\Requests\PurchaseFormRequest;
use PDF;
use NumberFormatter;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;


class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get data
        $data = Purchase::all();
        if(Purchase::latest()->first())
        {
            if(Purchase::latest()->first()->updated_at)
            {
                $lastUpdated = Purchase::latest()->first()->updated_at->diffForHumans();
            }
            else
            {
                $lastUpdated = "never";
            }
        }
        else
        {
            $lastUpdated = "never";
        }
        //return view with data
        return view('admin.purchase.index',compact('data','lastUpdated'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Set a variable for Purchase Type
        $purchase_types = config('purchase');
        //get all suppliers from users
        $d = Supplier::all();
        foreach ($d as $item) {
            if ($item->role()->first()->name == 'Exporter' or $item->role()->first()->name == 'Local Supplier') {
                $data[] = $item;
            }
        }
        if(!empty($data)){
            return view('admin.purchase.create', compact('data', 'purchase_types'));
        } else {
            return view('errors.404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseFormRequest $request)
    {
        //return $request->all();
        $purchase = new Purchase();
        $purchase->ref_no = $request->ref_no;
        $purchase->receive_date = $request->receive_date;
        $purchase->user_id = $request->user_id;
        $purchase->purchase_type = $request->purchase_type;
        $purchase->total = $request->total;
        $purchase->save();
        //Loop through the reset to attach
        for ($i = 0; $i < count($request['product_ids']); $i++) {
            //Attach to purchase details:
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
        return redirect(route('purchases.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get Purchase by id
        $purchase = Purchase::findOrFail($id);
        return view('admin.purchase.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Set a variable for Purchase Type
        $purchase_types = ['Local', 'Import'];
        //get all suppliers from users
        $d = Supplier::all();
        foreach ($d as $item) {
            if ($item->role()->first()->name == 'Exporter' or $item->role()->first()->name == 'Local Supplier') {
                $data[] = $item;
            }
        }
        //get Purchase by id
        $purchase = Purchase::findOrFail($id);
        return view('admin.purchase.edit', compact('purchase', 'data', 'purchase_types'));
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
        //
    }
    
    
    /*
     * function for ajax call
     */
    public function myAzax()
    {
        //get all products
        $products = Product::all();
        foreach ($products as $item){
            //get packing details
            if(!empty($item->packings->first())){
                $packing = $item->packings()->first()->name.", "
                            .$item->packings()->first()->quantity
                            .$item->units()->first()->short." x "
                            .$item->packings()->first()->multiplier;
            }else{
                $packing ='Undefined';
                
            }
            //get price
            $price = $item->packings()->first()->price;
            $items[] = ['id'=>$item->id, 'name'=>$item->name, 'packing'=>$packing, 'price'=>$price];
        }
        
        $data['items'] = $items;
        return json_encode($data);
    }
    
    /*
     * For printing:
     */
    public function pdf(Request $request)
    {
        //return $request;
        $purchase = Purchase::findOrFail($request->id);
        $inwords = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $purchase->inwords = $inwords->format($purchase->total);
        $pdf = PDF::loadView('admin.purchase.print', compact('purchase'))->setPaper('a4', 'portrait');
        //$pdf->save(storage_path().'_purchase.pdf');
        //return $pdf->download('purchase.pdf');
        $fileName = 'purchase_'.$purchase->ref_no;
        return $pdf->stream($fileName.'.pdf');
    }
    
    
    /*
     * Unique Reference Generator:
     */
    public function getUniqueRefNo() {
        //Generate Unique Reference No:
        $config = [
            'table' => 'purchases',
            'field' => 'ref_no',
            'length' => 17,
            'prefix' => 'vsf/'.date('y/m').'/buy-',
            'reset_on_prefix_change' => true
        ];
        $id = IdGenerator::generate($config);
        return Str::upper($id);
    }
    
    
}
