<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WastageFormRequest;
use App\Wastage;
use App\Store;
use App\Product;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Role;
use PDF;
use NumberFormatter;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class WastageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lastModified = Wastage::latest()->first();
        if($lastModified){
            if($lastModified->updated_at){
                $lastUpdated = $lastModified->updated_at->diffForHumans();
            }else{
                $lastUpdated = "never";
            }
        }else{
            $lastUpdated = "never";
        }
        $stores = Store::all();
        
        /*
         * Power Role check
         */
        $powerRoleCollection = Role::whereIn('name', [config('constants.roles.admin'), config('constants.roles.management')])->get('id');
        $powerRoleArray = [];
        foreach ($powerRoleCollection as $role) {
            array_push($powerRoleArray,$role->id);
        }
        //Sync roles:
        $userRolesArray = [];
        foreach (Auth::user()->roles as $role) {
            array_push($userRolesArray,$role->id);
        }
        if(empty(array_intersect($powerRoleArray, $userRolesArray))){
            $hasPowerRole = false;
        } else {
            $hasPowerRole = true;
        }

        if ($request->ajax()) {
            return DataTables::of(Wastage::query())
                ->addIndexColumn()  
                ->addColumn('wastage_date', function($row){
                    return !empty($row->wastage_date) ? Carbon::create($row->wastage_date)->toFormattedDateString() : "";
                })
                ->addColumn('is_approved', function($row){
                    return $row->is_approved ? '<span class="text-success"><i class="fas fa-check-circle"></i></span>' : '<span class="text-warning"><i class="fas fa-times-circle"></i></span>';
                })
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
                    $btn = $btn.'<a class="show dropdown-item" href="'.route('wastage.show', $row->id).'" target="_blank"><i class="fas fa-eye"></i> View</a>';
                    $btn = $btn.'<a class="edit dropdown-item" href="'.$row->id.'"><i class="fas fa-edit"></i> Edit</a>';
                    $btn = $btn.'<a class="del dropdown-item" href="'.$row->id.'"><i class="fas fa-trash-alt"></i> Delete</a>';
                    $btn = $btn.'<div class="dropdown-divider"></div>';
                    $btn = $btn.'<a class="pdf dropdown-item" href="'.$row->id.'"><i class="far fa-file-pdf"></i> PDF</a>';
                    $btn = $btn.'</div>';
                    $btn = $btn.'</div>';
                    return $btn;
                })
                ->rawColumns(['action','is_approved'])    
                ->make(true);
        }
        //return view with data
        return view('admin.wastage.index',compact('lastUpdated','stores','hasPowerRole'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WastageFormRequest $request)
    {
        $wastege = Wastage::create([
            'wastage_no' => $request->wastage_no,
            'wastage_date' => $request->wastage_date, 
            'wasted_at' => $request->wasted_at,
            'store_id' => $request->store_id, 
            'store_name' => $request->store_name,
            'quantity_type' => $request->quantity_type, 
            'issued_by' => Auth::user()->name,
            'is_approved' => $request->is_approved,
            'report' => $request->report,
            'approved_by' => ($request->is_approved ? Auth::user()->name : null),
        ]);
        if($wastege){
            for($i=0; $i < count($request['product_ids']); $i++){
                $product = Product::findOrFail($request['product_ids'][$i]);
                $wastege->stock()->attach($product->id, 
                        [
                            'quantity' => $product->productCountNormalizer($request->quantity_type, $request['quantities'][$i]), 
                            'store_id' => $request->store_id, 
                            'flag' => 'out'
                        ]);
            }
        }
        return response()->json([
            'status' =>true,
            'message' => 'Success!!! Wastage no '.$wastege->wastage_no.' is saved.' 
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
        $wastage = Wastage::findOrFail($id);
        $wastage->stock;
        return view('admin.wastage.show', compact('wastage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $wastage = Wastage::findOrFail($id);
        $wastage->stock;
        foreach ($wastage->stock as $item){
            $item->pivot->formated_qty = number_format($item->qtyDenormalizer($wastage->quantity_type,$item->pivot->quantity),2);
        }
        return response()->json([$wastage ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WastageFormRequest $request, $id)
    {
        $wastage = Wastage::findOrFail($id);
        $wastage->stock()->detach();
        $wastage->update([
            'wastage_date' => $request->wastage_date, 
            'wasted_at' => $request->wasted_at,
            'store_id' => $request->store_id, 
            'store_name' => $request->store_name,
            'quantity_type' => $request->quantity_type, 
            'issued_by' => Auth::user()->name,
            'is_approved' => $request->is_approved,
            'report' => $request->report,
            'approved_by' => ($request->is_approved ? Auth::user()->name : null),
        ]);
        if($wastage){
            for($i=0; $i < count($request['product_ids']); $i++){
                $product = Product::findOrFail($request['product_ids'][$i]);
                $wastage->stock()->attach($product->id, 
                        [
                            'quantity' => $product->productCountNormalizer($request->quantity_type, $request['quantities'][$i]), 
                            'store_id' => $request->store_id, 
                            'flag' => 'out'
                        ]);
            }
        }
        return response()->json([
            'status' =>true,
            'message' => 'Success!!! Wastage record no.'.$wastage->wastage_no.' has been updated.' 
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wastage = Wastage::findOrFail($id);
        //Detach all items from PIVOT (productable):
        $wastage->stock()->detach();
        //Finally delete:
        $wastage->delete();
        return response()->json([
            'status' =>true,
            'message' => 'Success!!! Wastage record no.'.$wastage->wastage_no.' has been deleted.' 
        ]);
    }
    
    
    /*
     * Unique Reference Generator:
     */
    public function getUniqueRefNo() {
        //Generate Unique Reference No:
        $config = [
            'table' => 'wastages',
            'field' => 'wastage_no',
            'length' => 17,
            'prefix' => 'vsf/'.date('y/m').'/wtg-',
            'reset_on_prefix_change' => true
        ];
        $id = IdGenerator::generate($config);
        return Str::upper($id);
    }
    
    /*
     * For printing:
     */
    public function pdf(Request $request)
    {
        //return $request;
        $wastage = Wastage::findOrFail($request->id);
        $wastage->stock;
        $pdf = PDF::loadView('admin.wastage.print', compact('wastage'))->setPaper('a4', 'portrait');
        $fileName = 'challan_'.$wastage->wastage_no;
        return $pdf->stream($fileName.'.pdf');
    }
    
}
