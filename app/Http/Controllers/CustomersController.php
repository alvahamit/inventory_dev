<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerFormRequest;
use App\User as Customer;
use App\Role;
use App\Address;
use App\Contact;
use App\Country;
use Yajra\DataTables\Facades\DataTables;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::whereIn('name',['Buyer', 'Customer', 'Client'])->pluck('name','id');
        $rolesArr =['Buyer', 'Customer', 'Client'];
        $countries = Country::all();
        $address_labels = ['work','residence','club','factory','gym', 'school'];
        $contact_labels = ['cell','work','res','club','factory','whatsapp','emergency'];
        $data = Customer::whereHas('role', function($q){
            $q->whereIn('name',['Buyer', 'Customer', 'Client']);
        });
        $data->latest()->first() ? $lastUpdated = $data->latest()->first()->updated_at->diffForHumans() : $lastUpdated = "never";
        if($request->ajax()){
            return DataTables::of($data->orderBy('id','desc')->get())
                    ->addColumn('name', function($row){
                        return '<a href="'.$row->id.'">'.$row->name.'</a>';
                    })
                    ->addColumn('role', function($row){
                        return $row->role->first()->name;
                    })
                    ->addColumn('address_first', function($row){
                        return $row->addresses()->first()->address;
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
        return view('admin.customer.index', compact('roles', 'countries','contact_labels','address_labels', 'lastUpdated'));
        
        
        
        
        //!empty($data) ? return view('admin.supplier.index', compact('data')) : return view('errors.404');
        if(!empty($data)){
            //return view('admin.supplier.index', compact('data','roles'));
            $collection = collect($data);
             dd($collection);
        } else {
            return view('errors.404');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerFormRequest $request)
    {
        $request->has('is_primary') ? $is_primary = 1 : $is_primary = 0 ;
        $request->has('is_billing') ? $is_billing = 1 : $is_billing = 0 ;
        $request->has('is_shipping') ? $is_shipping = 1 : $is_shipping = 0 ;
        //Create customer
        $customer = Customer::create([ 
            'name'=> $request->name, 
            'organization' => $request->organization,  
            'email' => $request->email 
        ]); 
        //Find role
        $role = Role::findOrFail($request->role);
        //Save role for customer
        $customer->role()->save($role);
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
        return response()->json(['request' => $request->all() ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        //Note: Call relations otherwise it will not be available.
        $customer->addresses;
        $customer->contacts;
        $customer->role;
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
    public function update(CustomerFormRequest $request, $id)
    {
        $request->has('is_primary') ? $is_primary = 1 : $is_primary = 0 ;
        $request->has('is_billing') ? $is_billing = 1 : $is_billing = 0 ;
        $request->has('is_shipping') ? $is_shipping = 1 : $is_shipping = 0 ;
        
        $customer = Customer::findOrFail($id);
     
//        $customer->contacts;
//        $customer->role;
        
        $customer->update([ 
            'name'=> $request->name, 
            'organization' => $request->organization, 
            'email' => $request->email 
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
        $customer = Customer::findOrFail($id);
        $customer->addresses()->detach();
        $customer->contacts()->detach();
        $customer->delete();
        return response()->json(['message' => 'Customer '.$customer->name.' removed.' ]);
    }
    
    /*
     * Delete Address:
     * Detach and delete specific address from user.
     */
    public function removeAddress(Request $request) {
        Customer::findOrFail($request->user_id)->addresses()->detach($request->address_id);
        Address::findOrFail($request->address_id)->delete();
        return response()->json(['message' => 'Address ID '.$request->address_id.' removed.' ]);
    }
    
    
    
}
