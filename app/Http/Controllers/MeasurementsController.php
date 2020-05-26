<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Measurement;

class MeasurementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all measurements
        $data = Measurement::all();
        //return view with data
        return view('admin.measurement.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view
        return view('admin.measurement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create record with data then redirect
        if(Measurement::create($request->all())){
            return redirect(route('measurements.index'));
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
        //get data by id
        $data = Measurement::findOrFail($id);
        //return view with data
        return view('admin.measurement.edit',compact('data'));
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
        //find instance by id
        $instance = Measurement::findOrFail($id);
        //update and redirect if success
        if($instance->update($request->all())){
            return redirect(route('measurements.index'));
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
        Measurement::findOrFail($id)->delete();
        return redirect(route('measurements.index'));
    }
}
