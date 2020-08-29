<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SupplierFormRequest;
use App\User as Supplier;
use App\Country;
use App\Address;
use App\Contact;
use App\Role;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;
use NumberFormatter;
use Illuminate\Support\Facades\Hash;



class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $countries = Country::all();
        $roles = Role::whereIn('name',[config('constants.roles.supplier'), config('constants.roles.exporter')])->pluck('name','id');
        $data = Supplier::whereHas('roles', function($q){
                    $q->whereIn('name', [config('constants.roles.supplier'), config('constants.roles.exporter')]);
                });
        $data->latest()->first() ? $lastUpdated = $data->latest()->first()->updated_at->diffForHumans() : $lastUpdated = "never";
        //Get all supplier(local supplier and exporter) data:
        $data = Supplier::whereHas('roles', function($q){
                    $q->whereIn('name', [config('constants.roles.supplier'), config('constants.roles.exporter')]);
                })->orderBy('id','desc')->get();
        if($request->ajax()){
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('role', function($row){
                    if($row->roles->count() > 0){
                        $array = $row->roles()->pluck('name');
                        $html= "<ul>";
                        foreach ($array as $item){$html .= "<li>".$item."</li>";}
                        $html .= "</ul>";
                        return $html;
                    }
                })
                ->addColumn('is_active', function($row){
                    return $row->is_active ? '<span class="text-success"><i class="fas fa-check-circle"></i></span>' : '<span class="text-warning"><i class="fas fa-times-circle"></i></span>';
                })
                ->addColumn('created_at', function($row){
                    return $row->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function($row){
                    return $row->updated_at->diffForHumans();
                })
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group">';
                    $btn = $btn.'<button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    $btn = $btn.'Action';
                    $btn = $btn.'</button>';
                    $btn = $btn.'<div class="dropdown-menu">';
                    $btn = $btn.'<a class="show dropdown-item" href="'.$row->id.'"><i class="fas fa-eye"></i> View</a>';
                    $btn = $btn.'<a class="edit dropdown-item" href="'.$row->id.'"><i class="fas fa-edit"></i> Edit</a>';
                    $btn = $btn.'<a class="del dropdown-item" href="'.$row->id.'"><i class="fas fa-trash-alt"></i> Delete</a>';
                    $btn = $btn.'<div class="dropdown-divider"></div>';
                    $btn = $btn.'<a class="yes dropdown-item" href="'.$row->id.'"><i class="far fa-check-circle"></i> Activate</a>';
                    $btn = $btn.'<a class="no dropdown-item" href="'.$row->id.'"><i class="far fa-times-circle"></i> Deactivate</a>';
                    $btn = $btn.'</div>';
                    $btn = $btn.'</div>';
                    return $btn;
                })
                ->rawColumns(['role', 'is_active','action'])
                ->make(true);
        }
        if(!empty($data)){
            return view('admin.supplier.index', compact('roles', 'lastUpdated', 'countries'));
        } else {
            return view('errors.404');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        //Set Supplier types as Role
//        $roles = \App\Role::where('name','Local Supplier')->orWhere('name','Exporter')->pluck('name','id');
//        //return view
//        return view('admin.supplier.create', compact('roles'));    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierFormRequest $request)
    {
        $request->has('is_primary') ? $is_primary = 1 : $is_primary = 0 ;
        $request->has('is_billing') ? $is_billing = 1 : $is_billing = 0 ;
        $request->has('is_shipping') ? $is_shipping = 1 : $is_shipping = 0 ;
        //Create user
        $user = Supplier::create([ 
            'name'=> ucwords($request->name), 
            'organization' => $request->organization, 
            'email' => $request->email,
            'password' => Hash::make('password'),
            'is_active' => $request->is_active
        ]);

        //Attach roles:
        foreach($request->roles as $role){
            $user->roles()->attach($role);
        }
        
        //Create address
        $address = Address::create([
            'label' => $request->address_label,
            'country_code' => $request->country_code,
            'address' => $request->address,
            'area' => $request->area,
            'state' => ucwords($request->state),
            'city' => ucwords($request->city),
            'postal_code' => $request->postal_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        //Save address for customer
        $user->addresses()->save(
                $address, 
                [
                    'is_primary' => $is_primary, 
                    'is_billing' => $is_billing, 
                    'is_shipping' => $is_shipping
                ]);
        //Create number (Looping through)
        for ($i = 0; $i < count($request->number); $i++) {
            $contact = Contact::create([
                'label' => $request->contact_label[$i],
                'country_code' => $request->country_code_contact[$i],
                'city_code' => $request->city_code_contact[$i],
                'number' => $request->number[$i],
            ]);
            $user->contacts()->save( $contact );
        }
        return redirect()->route('suppliers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Supplier::findOrFail($id);
        //Note: Call relations otherwise it will not be available.
        $user->addresses;
        $user->contacts;
        $user->roles;
        return response()->json(['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*
         * Note: We are not using edit blade any more.
         * Therefore this code is now obsolete.
         */
//        //Set Supplier types as Role
//        $roles = \App\Role::where('name','Local Supplier')->orWhere('name','Exporter')->pluck('name','id');
//        //get supplier by id
//        $data = Supplier::findOrFail($id);
//        return view('admin.supplier.edit', compact('data', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierFormRequest $request, $id)
    {
        //New Code:
        $request->has('is_primary') ? $is_primary = 1 : $is_primary = 0 ;
        $request->has('is_billing') ? $is_billing = 1 : $is_billing = 0 ;
        $request->has('is_shipping') ? $is_shipping = 1 : $is_shipping = 0 ;
        //Find user:
        $user = Supplier::findOrFail($id);
        $user->update([
                    'name'=> ucwords($request->name), 
                    'organization' => $request->organization, 
                    'email' => $request->email,
                    'is_active' => $request->is_active
                ]);
        if(!empty($request->address_id)){
            //Find and Update address:
            foreach($user->addresses as $address){
                $address->whereId($request->address_id)->update([
                    'label' => $request->address_label,
                    'country_code' => $request->country_code,
                    'address' => $request->address,
                    'area' => $request->area,
                    'state' => ucwords($request->state),
                    'city' => ucwords($request->city),
                    'postal_code' => $request->postal_code,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]);
            }
            $user->addresses()->updateExistingPivot(
                        $request->address_id, 
                        [
                            'is_primary' => $is_primary, 
                            'is_billing' => $is_billing, 
                            'is_shipping' => $is_shipping
                        ]
                    );
        } else {
            //Create address:
            $address = Address::create([
                'label' => $request->address_label,
                'country_code' => $request->country_code,
                'address' => $request->address,
                'area' => $request->area,
                'state' => $request->state,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
            //Save address for customer
            $user->addresses()->save(
                    $address, 
                    [
                        'is_primary' => $is_primary, 
                        'is_billing' => $is_billing, 
                        'is_shipping' => $is_shipping
                    ]);
        }
        
        //Check and detach appropriate roles from user:
        $idsArray = Role::whereIn('name',[config('constants.roles.supplier'), config('constants.roles.exporter')])->pluck('id')->toArray();
        foreach($user->roles as $role){
            if(in_array($role->id, $idsArray)){
                $user->roles()->detach($role->id);
            }
        }
        //Attach update form roles to user:
        $rolesArray = [];
        foreach($request->roles as $role){
            array_push($rolesArray,$role);
        }
        $user->roles()->attach($rolesArray);
        
        
        if( $user->contacts->count() > 0 ){
            // Detach old contacts from lookup table.
            // Then delete old contacts.
            foreach($user->contacts as $contact){
                $contact_ids[] = $contact->id; 
            }
            $user->contacts()->detach();
            Contact::whereIn('id',$contact_ids)->delete();
        } 
        // Create contact number (Looping through) from request.
        for ($i = 0; $i < count($request->number); $i++) {
            $contact = Contact::create([
                'label' => $request->contact_label[$i],
                'country_code' => $request->country_code_contact[$i],
                'city_code' => $request->city_code_contact[$i],
                'number' => $request->number[$i],
            ]);
            $user->contacts()->save( $contact );
        }
        return response()->json(['request' => $request->all() ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Supplier::findOrFail($id);
        //Roles check:
        //Check and detach appropriate roles from user:
        $userRoleIdsArr = $user->roles()->pluck('id')->toArray();
        $allowedRoleIdsArr = Role::whereIn('name',[config('constants.roles.supplier'), config('constants.roles.exporter')])->pluck('id')->toArray();
        if(empty(array_diff($userRoleIdsArr,$allowedRoleIdsArr))){
            if( $user->purchases->count() == 0 ){
                $user->roles()->detach();
                $user->addresses()->detach();
                $user->contacts()->detach();
                $user->delete();
                return response()->json([
                    'status' =>true,
                    'message' => 'Supplier '.$user->name.' removed.' 
                ]);
            } else {
                return response()->json([
                    'status' =>false,
                    'message' => 'Sorry!!! Supplier cannot be removed. Purchases have been made from '.$user->name.'.' 
                ]);
            }
            
        } else {
            return response()->json([
                'status' =>false,
                'message' => 'Supplier '.$user->name.' is also a system user. Cannot delete user.' 
            ]);
        }       
    }
}
