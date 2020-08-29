<!-- 
    Author:     Alvah Amit Halder
    Document:   Categories create blade.
    Model/Data: App\Category
    Controller: CategoryController
-->

@extends('theme.default')

@section('title', __('VSF-Category'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Create Category'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Create Category</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<div class="col-md-8 offset-md-2">
    <div class="card card-register mx-auto mt-5">
        <div class="card-header">Register new category</div>
        <div class="card-body">
            <form method="POST" action="{{route('categories.store')}}" accept-charset="UTF-8">
                @csrf
                <div class="form-group">
                    <label for="name">Category Name:</label>
                    <input type="text" name="name" id="name" class="form-control" autofocus="autofocus" value="{{old('name')}}" required="required">
                </div>
                <div class="form-group">
                    <label for="description">Category Description (optional):</label>
                    <textarea type="text" name="description" id="description" class="form-control" rows="4">{{old('description')}}</textarea>
                </div>
                <input class="btn btn-primary btn-block" type="submit" value="Register">
            </form>
            @include('includes.display_form_errors')
        </div>
    </div>
</div>
@stop