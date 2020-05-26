<!-- 
    Author:     Alvah Amit Halder
    Document:   Categories create blade.
    Model/Data: App\Category
    Controller: CategoryController
-->

@extends('theme.default')

@section('title', __('VSF-Category'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Update or Delete Category'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Edit Category</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<!--<h1>Hi!! you can edit categories here.</h1><hr>-->
<div class="card card-register mx-auto mt-5">
    <div class="card-header">Update category</div>
    <div class="card-body">
        <form method="POST" action="{{route('categories.update',$data->id)}}" accept-charset="UTF-8">
            {{method_field('PATCH')}}
            @csrf
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control" 
                        placeholder="Category name" 
                        autofocus="autofocus" 
                        value="{{old('name', $data->name)}}"
                        required="required">
                    <label for="name">Edit category name</label>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Edit category description (optional):</label>
                    <textarea
                        type="text" 
                        name="description" 
                        id="description" 
                        class="form-control" 
                        value=""
                        rows="3">{{old('description', $data->description)}}</textarea>
            </div>
            <!--Buttons with separate form for delete-->
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <input class="btn btn-primary btn-block" type="submit" value="Save">
                    </div> 
                    </form>
                    <div class="col-md-6">
                        <form method="POST" action="{{route('categories.destroy', $data->id)}}" accept-charset="UTF-8">
                            {{method_field('DELETE')}}
                            @csrf
                            <input class="btn btn-danger btn-block" type="submit" value="Delete">
                            </div> 
                        </form>
                    </div>
                </div>
        @include('includes.display_form_errors')
    </div>
</div>
@stop