<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsersFormRequest;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\Country;
use App\Address;
use App\Contact;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;
use NumberFormatter;

class UsersController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
//    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = Country::all();
        $roles = Role::pluck('name','id')->all();
        $users = User::all();
        User::latest()->first() ? $lastUpdated = User::latest()->first()->updated_at->diffForHumans() : $lastUpdated = "never" ;
        if ($request->ajax()){
            $datatable = DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('role', function($row) {
                    if($row->roles->count() > 0){
                        $array = $row->roles()->pluck('name');
                        $html= "<ul>";
                        foreach ($array as $item){
                            $html .= "<li>".$item."</li>";
                        }
                        $html .= "</ul>";
                        return $html;
                    }
                    //return $row->roles->count() > 0 ? $row->roles()->pluck('name') : '<span style="color:red">Unassigned</span>' ;
                })
                ->addColumn('is_active', function($row){
                        return $row->is_active ? '<span class="text-success"><i class="fas fa-check-circle"></i></span>' : '<span class="text-warning"><i class="fas fa-times-circle"></i></span>';
                })
                ->addColumn('created_at', function($row) {
                    return $row->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function($row) {
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
                    $btn = $btn.'</div>';
                    $btn = $btn.'</div>';
                    return $btn;
                })
                ->rawColumns(['role','is_active', 'action'])
                ->make(true);
            return $datatable;   
        } 
        if(!empty($users)){
            return view('admin.user.index', compact('users', 'lastUpdated', 'countries', 'roles'));
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
        /*
         * Note: We are not using create blade any more.
         * Therefore this code is now obsolete.
         */
//        //$rolesArr =['Buyer', 'Customer', 'Client'];
//        $countries = Country::all();
//        $address_labels = ['work','residence','club','factory','gym', 'school'];
//        $contact_labels = ['cell','work','res','club','factory','whatsapp','emergency'];
//        //get role names and ids
//        $roles = Role::pluck('name','id')->all();
//        return view('admin.user.create', compact('roles', 'countries','contact_labels','address_labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersFormRequest $request)
    {
        //return response()->json([ $request->all() ]);
        $request->has('is_primary') ? $is_primary = 1 : $is_primary = 0 ;
        $request->has('is_billing') ? $is_billing = 1 : $is_billing = 0 ;
        $request->has('is_shipping') ? $is_shipping = 1 : $is_shipping = 0 ;
        !empty($request->password) ? $password = Hash::make($request->password) : $password = Hash::make('password') ;
        //Create user
        $user = User::create([ 
            'name'=> ucwords($request->name),
            'username'=> $request->username,
            'organization' => $request->organization, 
            'email' => $request->email, 
            'password' => $password,
            'is_active' => $request->is_active
        ]);
        //Find admin role id:
        $adminRoleId = Role::whereName(config('constants.roles.admin'))->first()->id;
        //Attach roles:
        foreach($request->roles as $role){
            $user->roles()->attach($role);
            if($role == $adminRoleId){
                $user->update(['is_admin' => true]);
            }
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
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
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
//        $countries = Country::all();
//        $address_labels = ['work','residence','club','factory','gym', 'school'];
//        $contact_labels = ['cell','work','res','club','factory','whatsapp','emergency'];
//        //get user data by id
//        $data = User::findOrFail($id);
//        //pluck roles name and id
//        $roles = Role::pluck('name','id')->all();
//        //return view with data
//        return view('admin.user.edit', compact('roles','data', 'countries','contact_labels','address_labels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersFormRequest $request, $id)
    {
        //Old code:
        /*
        $user = User::findOrFail($id);
        $user->name = ucwords($request->name);
        $user->email = strtolower($request->email);
        $user->password = Hash::make($request->password);
        if($user->update()){
            $user->role()->sync($request->role);
            return redirect()->route('users.index');
        }
        */
        //New Code:
        $request->has('is_primary') ? $is_primary = 1 : $is_primary = 0 ;
        $request->has('is_billing') ? $is_billing = 1 : $is_billing = 0 ;
        $request->has('is_shipping') ? $is_shipping = 1 : $is_shipping = 0 ;
        //Find user:
        $user = User::findOrFail($id);
        if(!empty($request->password)){
            $user->update([
                    'name'=> ucwords($request->name), 
                    'username'=> $request->username,
                    'organization' => $request->organization, 
                    'email' => $request->email,
                    'is_active' => $request->is_active,
                    'password' => Hash::make($request->password) 
                ]);
        } else {
            $user->update([
                    'name'=> ucwords($request->name),
                    'username'=> $request->username,
                    'organization' => $request->organization, 
                    'email' => $request->email,
                    'is_active' => $request->is_active
                ]);
        }
        
        //Find admin role id:
        $adminRoleId = Role::whereName(config('constants.roles.admin'))->first()->id;
        //Sync roles:
        $rolesArray = [];
        foreach($request->roles as $role){
            array_push($rolesArray,$role);
        }
        $user->roles()->sync($rolesArray);
        if(in_array($adminRoleId, $rolesArray)){
            $user->update(['is_admin' => true]);
        } else {
            $user->update(['is_admin' => false]);
        }
        
        if(!empty($request->address_id)){
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
            $user->addresses()->save(
                    $address, 
                    [
                        'is_primary' => $is_primary, 
                        'is_billing' => $is_billing, 
                        'is_shipping' => $is_shipping
                    ]);
        }
               
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
        //find user by id then delete
        $user = User::findOrFail($id);
        $user->roles()->detach();
        $user->addresses()->detach();
        $user->contacts()->detach();
        $user->delete();
        return response()->json(['message' => 'Customer '.$user->name.' removed.' ]);
        //return redirect(route('users.index'));
        
        
    }
    
    /*
     * Activate User:
     */
    public function activate(Request $request) {
        $user = User::findOrFail($request->id);
        $user->update([
            'is_active' => true,
        ]);
        return response()->json([
            'status'=> true,
            'message' => "Success!!! ".$user->name." has been activated."
        ]);
    }
    
    /*
     * DeActivate User:
     */
    public function deactivate(Request $request) {
        $user = User::findOrFail($request->id);
        $user->update([
            'is_active' => false,
        ]);
        return response()->json([
            'status'=> true,
            'message' => "Success!!! ".$user->name." has been deactivated."
        ]);
    }
    
    
    /*
     * Delete Address:
     * Detach and delete specific address from user.
     */
//    public function removeAddress(Request $request) {
//        User::findOrFail($request->user_id)->addresses()->detach($request->address_id);
//        Address::findOrFail($request->address_id)->delete();
//        return response()->json(['message' => 'Address ID '.$request->address_id.' removed.' ]);
//    }
    
    
}
