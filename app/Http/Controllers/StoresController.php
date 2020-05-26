<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Product;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all stores
        $data = Store::all();
        //return view with data
        return view('admin.store.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return form
        return view('admin.store.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //save data in database
        Store::create($request->all());
        return redirect(route('stores.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get instance by id
        $store = Store::findOrFail($id);
        //return view with data
        return view('admin.store.edit', compact('store'));
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
        //get instance by id
        $instance = Store::findOrFail($id);
        //update and redirect
        if($instance->update($request->all())){
            return redirect(route('stores.index'));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*
         * Need to check if store is used.
         */
        //delete
        Store::findOrFail($id)->delete();
        return redirect(route('stores.index'));
    }
    
    
    
    /*
     * Ajax store product fecher for Challan.
     * Explanation:
     * map() method is used to iterate through the full collection. It accepts a callback as an argument. 
     * $value and the $key is passed to the callback. Callback can modify the values and return them. 
     * Finally, a new collection instance of modified items is returned.
     */
    public function getStoreProducts(Request $request) {
        $store = Store::findOrFail($request->id);
        if(count($store->stocks) > 0){
            $store_pivot = $store->stocks->map(function($value, $key){ 
                $value['flag'] === 'out' ? $value['quantity'] = 0-$value['quantity'] : $value['quantity']; 
                return $value;
            });
            $store_stock = collect();
            $unique_ids = $store_pivot->pluck('product_id')->unique();
            foreach($unique_ids as $product_id){ 
                $product = Product::findOrfail($product_id);
                $packing = $product->packings()->first()->name.", ".$product->packings()->first()->quantity.$product->units()->first()->short." x ".$product->packings()->first()->multiplier;
                $collect = collect(['product_id'=>$product_id, 'name'=>$product->name, 'packing'=>$packing, 'quantity'=>($store_pivot->where('product_id',$product_id)->sum('quantity')) ]);
                $store_stock->push($collect);
            };
            return response()->json(['store' => $store_stock ]);
        } else {
            return response()->json([
                'errors' => [
                  'empty_store' => ['This store is empty.']
                ]], 422);
        }
        
    }
    
    
}


