<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryFormRequest;
use App\Category;
use Illuminate\Support\Facades\Session;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all categories
        $allCat = Category::all();
        $data = Category::whereNull('category_id')->with('childrenCategories')->get();
        //get view and pass data.
        return view('admin.category.index',compact('data','allCat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryFormRequest $request)
    {
        $category = Category::create($request->all());
        Session::flash('success', 'Category '.$category->name.' stored.');
        //return response()->json(['request' => $request->all()]);
        return response()->json([
            'status' => true,
            'message' => 'Category '.$category->name.' stored.'
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
        //get category by id
        $data = Category::findOrFail($id);
        //return view with data
        return view('admin.category.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryFormRequest $request, $id)
    {
        $cat = Category::findOrFail($id);
        if($request->has('root')){
            $cat->update(['category_id' => null]);
            $cat->update($request->all());
        } else {
            $cat->update($request->all());
        }
        Session::flash('success', 'Category '.$cat->name.' updated.');
        //return response()->json($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Category '.$cat->name.' updated.'
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
        $cat = Category::findOrFail($id);
        if($cat->categories->count() > 0){
            Category::whereCategoryId($cat->id)->delete();
        }
        $cat->delete();
        Session::flash('success', 'Category '.$cat->name.' deleted.');
        return response()->json([
            'status' => true,
            'message' => 'Category '.$cat->name.' deleted.'
        ]);
    }
}
