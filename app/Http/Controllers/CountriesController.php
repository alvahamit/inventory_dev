<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all countries
        //$data = Country::all();
        //Get countries paginated
        $data = Country::paginate(8);
        //return view
        return view('admin.country.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return form
        return view('admin.country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //get new instance
        $instance = new Country();
        $instance->name = ucwords($request->name);
        $instance->code = strtoupper($request->code);
        if($instance->save()){
            return redirect(route('countries.index')); 
        }  
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
        //get country by id
        $country = Country::findOrFail($id);
        //return view
        return view('admin.country.edit', compact('country'));
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
        $instance = Country::findOrFail($id);
        //Set new value
        $instance->name=ucwords($request->name);
        $instance->code=strtoupper($request->code);
        //update and redirect if success
        if($instance->update()){
            return redirect(route('countries.index'));
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
        Country::findOrFail($id)->delete();
        return redirect(route('countries.index'));
    }
}
