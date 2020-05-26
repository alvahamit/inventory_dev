<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User as Supplier;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SupplierAjaxFormRequest;
/*
 * Yajra Laravel Datatable Implimentation.
 */
use Yajra\DataTables\Facades\DataTables;

class SuppliersController extends Controller
{
    public function index(Request $request) {
        
        if($request->ajax()){
            //get all suppliers from users
            $d = Supplier::all();
            foreach ($d as $item) {
                if(count($item->role) != 0){
                    if ($item->role()->first()->name == 'Exporter' or $item->role()->first()->name == 'Local Supplier') {
                        $data[] = $item;
                    }
                }
            }
            //$data = collection($data);
            
            return DataTables::of($data)
                    ->addColumn('name', function($row){
                        return '<a href="'.$row->id.'">'.$row->name.'</a>';
                    })
                    ->addColumn('role', function($row){
                        return $row->role->first()->name;
                    })
                    ->addColumn('created_at', function($row){
                        return $row->created_at->diffForHumans();
                    })
                    ->addColumn('updated_at', function($row){
                        return $row->updated_at->diffForHumans();
                    })
                    ->rawColumns(['name'])
                    ->make(true);
        }
        
        return view('admin.supplier.index');
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SupplierAjaxFormRequest;  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierAjaxFormRequest $request){
        //Save request
        $newSupplier = new Supplier($request->except('role'));
        if($newSupplier->save()){
            $newSupplier->role()->attach($request->role);
        }
        return response()->json(['success'=>'Added new records.']);
    }
    
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Set Supplier types as Role
        //$roles = \App\Role::where('name','Local Supplier')->orWhere('name','Exporter')->pluck('name','id');
        //get supplier by id
        $data = Supplier::findOrFail($id);
        $role = $data->role;
        //return view('admin.supplier.edit', compact('data', 'roles'));
        return response()->json([$data, $role]);
    }
    
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierAjaxFormRequest $request, $id)
    {
        //find suppler by id
        $supplier = Supplier::findOrFail($id);
        //update with reqest
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        if($supplier->update()){
            $supplier->role()->sync($request->role);
            return response()->json(['success'=>'Updated record.']);
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
        //find supplier by id then delete
        $supplier = Supplier::findOrFail($id);
        $supplier->role()->detach();
        $supplier->delete();
        return response()->json(['success'=>'Reached destroy method.']);
    }
    
    
    
}
