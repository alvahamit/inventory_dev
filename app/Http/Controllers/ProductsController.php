<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Country;
use App\Measurement;
use App\Packing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all products
        $data = Product::all();
        if(Product::latest()->first())
        {
            if(!empty(Product::latest()->first()->updated_at))
            {
                $lastUpdated = Product::latest()->first()->updated_at->diffForHumans();
            }
            else 
            {
               $lastUpdated = "00:00:00"; 
            }
        } 
        else 
        {
            $lastUpdated = "00:00:00";
        }
        //Product::latest()->first() ? $lastUpdated = Product::latest()->first()->updated_at->diffForHumans() : $lastUpdated = "00:00:00";
        return view('admin.product.index', compact('data', 'lastUpdated'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get countries
        $countries = Country::all();
        //get measurement units
        $units = Measurement::all();
        //return view
        return view('admin.product.create', compact('countries', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //get new model instance
        $newProduct = new Product();
        $newProduct->name = ucwords($request->name);
        $newProduct->description = $request->description;
        $newProduct->brand = ucwords($request->brand);
        $newProduct->country_id = $request->country_id;
        if($newProduct->save()){
            $packing = new Packing();
            $packing->name = $request->packing_name;
            $packing->product_id = $newProduct->id;
            $packing->measurement_id = $request->measurement_id;
            $packing->quantity = $request->quantity;
            $packing->multiplier = $request->multiplier;
            $packing->price = $request->price;
            $packing->save();
        }
        Session::flash('success', $newProduct->name.' created.');
        return redirect(route('products.index'));
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
        //find product
        $product = Product::findOrFail($id);
        //get countries
        $countries = Country::all();
        //get measurement units
        $units = Measurement::all();
        //return view
        return view('admin.product.edit', compact('product', 'countries', 'units'));
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
        //find product
        $product = Product::findOrFail($id);
        if(!empty($product->packings->first())){
            $packing = Packing::findOrFail($product->packings()->first()->id);
        }else{
            $packing = new Packing();
            $packing->product_id = $id;
        }
        //update product with request data.
        $product->name = $request->name;
        $product->description = $request->description;
        $product->brand = ucwords($request->brand);
        $product->country_id = $request->country_id;
        
        //update packing with request data.
        $packing->name = $request->packing_name;
        $packing->measurement_id = $request->measurement_id;
        $packing->quantity = $request->quantity;
        $packing->multiplier = $request->multiplier;
        $packing->price = $request->price;
        
        //update table record
        if($product->update()){
            $packing->save();
        }
        Session::flash('success', $product->name.' updated.');
        return redirect(route('products.index'));
        //return $packing;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find product
        $product = Product::findOrFail($id);
        if($product->purchases->count() == 0){
            //find product packing
            $packing = Packing::findOrFail($product->packings()->first()->id);
            //delete
            $packing->delete();
            $product->delete();
            Session::flash('success', $product->name.' deleted.');
            return redirect(route('products.index'));
        } else {
            Session::flash('errors', 'Product in use. '.$product->name.' cannot be deleted.');
            return redirect(route('products.index'));
        }
    }
}
