<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Productable;
use App\Product;
use App\Store;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*
         * Get all stores for store chooser:
         */
        $stores = Store::all();
        view('admin.stock', compact('stores'));
        
        /*
         * Ajax call for Datatable method:
         */
        if ($request->ajax()) {
            !empty($request->formatter) ? $formatter = $request->formatter : $formatter = "";
            !empty($request->store_id) ? $store_id = $request->store_id : $store_id = "";
            return DataTables::of(Product::query())
                    ->addColumn('name', function($row) {
                        return $row->name;
                    })
                    ->addColumn('description', function($row) {
                        if(!empty($row->packings->first())){
                            return $row->description.', Packing: '.$row->packings()->first()->name.", "
                                .$row->packings()->first()->quantity
                                .$row->units()->first()->short." x "
                                .$row->packings()->first()->multiplier;
                        } else {
                            return $row->description.', Packing: <span style="color: red">Undefined.</span>';
                        }
                    })
                    ->addColumn('brand', function($row) {
                        return $row->brand;
                    })
                    ->addColumn('country', function($row) {
                        return $row->country->name;
                    })
                    ->addColumn('price', function($row) use($formatter, $store_id) {
                        if(!empty($row->packings->first())){
                            //return $row->packings()->first()->price;
                            return $row->itemStock($formatter, $store_id)['price'];
                        } else {
                            return '<span style="color: red">0.00</span>';
                        }
                    })
                    ->addColumn('stock', function($row) use($formatter, $store_id) {
                        if( $row->itemStock($formatter, $store_id)['qty'] < 1 ){
                            return "<span style = 'color: red'>".$row->itemStock($formatter, $store_id)['qty']." ".$row->itemStock($formatter, $store_id)['unit']."</span>";
                        } else {
                            return $row->itemStock($formatter, $store_id)['qty']." ".$row->itemStock($formatter, $store_id)['unit'];
                        }
                        
                    })
                    ->rawColumns(['price', 'stock'])
                    ->make(true);
        }
        
        
        
        
        
        
    } //End of Index method.
}
