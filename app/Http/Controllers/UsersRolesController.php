<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class UsersRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Role::latest()->first() ? $lastUpdated = Role::latest()->first()->updated_at->diffForHumans() : $lastUpdated = "never" ;
        //Get all roles
        $roles = Role::all();
        //Pass the value into view.
        return view('admin.role.index', compact('roles', 'lastUpdated'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Return view
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Create role:
        $newRole =new Role();
        $newRole->name = ucwords($request->name);
        $newRole->description = ucfirst($request->description);
        $newRole->save();
        return redirect(route('roles.index'));
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
        //get data by id
        $data = Role::findOrFail($id);
        //return view with data
        return view('admin.role.edit', compact('data'));
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
        //instantiate object by id
        $role = Role::findOrFail($id);
        //set updated data
        $role->name = ucwords($request->name);
        $role->description = $request->description;
        if($role->update()){
            return redirect(route('roles.index'));
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
        //delete
        Role::findOrFail($id)->delete();
        return redirect(route('roles.index'));
    }
}
