<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerFormRequest as LeadFormRequest;
use App\User as Lead;
use App\Role;
use App\Address;
use App\Contact;
use App\Country;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::where('name',config('constants.roles.lead'))->pluck('name','id');
        $countries = Country::all();
        $data = Lead::whereHas('roles', function($q){
            $q->where('name',config('constants.roles.lead'));
        });
        $data->latest()->first() ? $lastUpdated = $data->latest()->first()->updated_at->diffForHumans() : $lastUpdated = "never";
        
        //Get all customers(buyer, client, customer) data:
        $data = Lead::whereHas('roles', function($q){
            $q->whereIn('name',[config('constants.roles.lead')]);
        })->orderBy('name','asc')->get();
        
        if($request->ajax()){
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('name', function($row){
                        //return '<a href="'.$row->id.'">'.$row->name.'</a>';
                        return $row->name;
                    })
                    ->addColumn('role', function($row){
                        //return $row->role->first()->name;
                        if($row->roles->count() > 0){
                            $array = $row->roles()->pluck('name');
                            $html= "<ul>";
                            foreach ($array as $item){
                                $html .= "<li>".$item."</li>";
                            }
                            $html .= "</ul>";
                            return $html;
                        }
                    })
                    ->addColumn('address_first', function($row){
                        $count =  count($row->addresses()->get());
                        return $count != 0 ? $row->addresses()->first()->address : "No address found"; 
                    })
                    ->addColumn('is_active', function($row){
                        $yes = '<span class="text-success"><i class="fas fa-check-circle"></i></span>';
                        $no = '<span class="text-warning"><i class="fas fa-times-circle"></i></span>';
                        return $row->is_active ? $yes : $no;
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
                        $btn = $btn.'<a class="yes dropdown-item" href="'.$row->id.'"><i class="far fa-check-circle"></i> Active</a>';
                        $btn = $btn.'<a class="no dropdown-item" href="'.$row->id.'"><i class="far fa-times-circle"></i> Deactive</a>';
                        $btn = $btn.'<a class="convert dropdown-item" href="'.$row->id.'"><i class="fas fa-dollar-sign"></i> Convert</a>';
                        $btn = $btn.'</div>';
                        $btn = $btn.'</div>';
                        return $btn;
                    })
                    ->rawColumns(['name','role','is_active','action'])
                    ->make(true);
        }
        return view('admin.lead.index', compact('roles', 'countries', 'lastUpdated'));
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
    public function store(LeadFormRequest $request)
    {
        $request->has('is_primary') ? $is_primary = 1 : $is_primary = 0 ;
        $request->has('is_billing') ? $is_billing = 1 : $is_billing = 0 ;
        $request->has('is_shipping') ? $is_shipping = 1 : $is_shipping = 0 ;
        //Create customer
        $customer = Lead::create([ 
            'name'=> $request->name, 
            'organization' => $request->organization,  
            'email' => $request->email,
            'password' => Hash::make('password'),
            'is_active' => $request->is_active
        ]); 
        //Attach system default role for Lead:
        $customer->roles()->attach(Role::whereName(config('constants.roles.lead'))->first());
        //Create address
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
        $customer->addresses()->save(
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
            $customer->contacts()->save( $contact );
        }
        return response()->json([
                'status' =>true,
                'message' => 'New lead '.$customer->name.' saved.' 
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
        $customer = Lead::findOrFail($id);
        //Note: Call relations otherwise it will not be available.
        $customer->addresses;
        $customer->contacts;
        $customer->roles;
        return response()->json(['customer' => $customer]);
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
    public function update(LeadFormRequest $request, $id)
    {
        $request->has('is_primary') ? $is_primary = 1 : $is_primary = 0 ;
        $request->has('is_billing') ? $is_billing = 1 : $is_billing = 0 ;
        $request->has('is_shipping') ? $is_shipping = 1 : $is_shipping = 0 ;
        
        $customer = Lead::findOrFail($id);
        $customer->update([ 
            'name'=> $request->name, 
            'organization' => $request->organization, 
            'email' => $request->email,
            'is_active' => $request->is_active
        ]);
        if(!empty($request->address_id)){
            foreach($customer->addresses as $address){
                $address->whereId($request->address_id)->update([
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
            }
            $customer->addresses()->updateExistingPivot(
                        $request->address_id, 
                        [
                            'is_primary' => $is_primary, 
                            'is_billing' => $is_billing, 
                            'is_shipping' => $is_shipping
                        ]
                    );

        } else {
            //Create address
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
            $customer->addresses()->save(
                $address, 
                [
                    'is_primary' => $is_primary, 
                    'is_billing' => $is_billing, 
                    'is_shipping' => $is_shipping
                ]);
        }
        if( $customer->contacts->count() > 0 ){
            // Detach old contacts from lookup table.
            // Then delete old contacts.
            foreach($customer->contacts as $contact){
                $contact_ids[] = $contact->id; 
            }
            $customer->contacts()->detach();
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
            $customer->contacts()->save( $contact );
        }
        return response()->json([
                'status' =>true,
                'message' => 'Lead data for '.$customer->name.' has been updated.' 
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
        $customer = Lead::findOrFail($id);
        $name = $customer->name;
        $company = $customer->organization;
        //Roles check:
        //Check and detach appropriate roles from user:
        $userRoleIdsArr = $customer->roles()->pluck('id')->toArray();
        $allowedRoleIdsArr = Role::whereIn('name',[config('constants.roles.lead')])->pluck('id')->toArray();
        if(empty(array_diff($userRoleIdsArr,$allowedRoleIdsArr))){
            if($customer->orders()->count() == 0){
                $customer->roles()->detach();
                $customer->addresses()->detach();
                $customer->contacts()->detach();
                $customer->delete();
                return response()->json([
                    'status'=> true,
                    'message' => "Success!!! Lead, ".$name." of ".$company.", has been deleted."
                ]);
            } else{
                return response()->json([
                    'status' => false,
                    'message' => "Sorry!!! ".$name." has orders. Please delete ".$name."'s orders first."
                ]);
            }
        } else{
            return response()->json([
                'status' =>false,
                'message' => 'Lead '.$customer->name.' is also a system user. Cannot delete user.' 
            ]);
        }
    }

    /*
     * 
     */
    public function convert(Request $request)
    {
        $customer = Lead::findOrFail($request->id);
        //Check and detach appropriate roles from user:
        $userRoleIdsArr = $customer->roles()->pluck('id')->toArray();
        $allowedRoleIdsArr = Role::whereIn('name',[config('constants.roles.lead')])->pluck('id')->toArray();
        if(empty(array_diff($userRoleIdsArr,$allowedRoleIdsArr))){
            $customer->roles()->detach($allowedRoleIdsArr);
            //Attach system default role for Client/Customer:
            $customer->roles()->attach(Role::whereName(config('constants.roles.client'))->first());
            return response()->json([
                'status'=> true,
                'message' => "Congratulations!!! Lead, ".$customer->name." has been converted to a Client."
            ]);
        } else {
            return response()->json([
                'status' =>false,
                'message' => 'Cannot convert Lead '.$customer->name.'.' 
            ]);
        }
    }
    
}
