<!-- 
    Author:     Alvah Amit Halder
    Document:   Product's Create blade.
    Model/Data: App\Product
    Controller: ProductsController@store
-->

@extends('theme.default')

@section('title', __('VSF-Products'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Create Product'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">Create Product</li>
</ol>
<!--<h1>Hi!! you can register new products here.</h1><hr>-->
<div class="col-md-8 offset-md-2">
    <form method="POST" action="{{route('products.store')}}" accept-charset="UTF-8">
    @csrf
    <!--card-->
    <div class="card card-register mx-auto mt-5">
        <div class="card-header">General info.</div>
        <div class="card-body">    
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" name="name" id="name" class="form-control" autofocus="autofocus" value="{{old('name')}}" required="required">
            </div>
            <div class="form-group">
                <label for="description">Product Description (optional):</label>
                <textarea type="text" name="description" id="description" class="form-control" rows="3">{{old('description')}}</textarea>
            </div>
            <div class="form-group">
                <label for="brand">Brand Name:</label>
                <input type="text" name="brand" id="brand" class="form-control" value="{{old('brand')}}" required="required">
            </div>
            <div class="form-group">
                <label for="country_id">Country of Origin:</label>
                <select class="custom-select" name="country_id" required="required">
                    <option selected="selected" value="">Pick a country of origin...</option>
                    @foreach($countries as $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>
                    @endforeach
                </select>    
            </div>
        </div> <!--./card body-->    
    </div> <!--./card card-register mx-auto mt-5-->

    <!--new card-->
    <div class="card card-register mx-auto mt-5">
        <div class="card-header">Packing and price info.</div>
        <div class="card-body">
            <div class="form-group">
                <label for="packing_name">Packing Name:</label>
                <input type="text" name="packing_name" id="packing_name" class="form-control" value="{{old('packing_name')}}" required="required">
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="measurement_id">Measure Unit Name:</label>
                            <select class="custom-select" name="measurement_id" required="required">
                                <option selected="selected" value="">Pick a unit...</option>
                                @foreach($units as $unit)
                                <option value="{{$unit->id}}">{{$unit->unit}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="{{old('quantity')}}" required="required">
                    </div>
                    <div class="col-md-4">
                        <label for="multiplier">Multiplier (x pcs):</label>
                        <input type="number" name="multiplier" id="multiplier" class="form-control" value="{{old('multiplier')}}" required="required">
                    </div>
                </div> <!--./form-row-->
                <div class="form-row">
                    <div class="col-md-4">
                    <label for="price">Selling Price (BDT):</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{old('price')}}" required="required">
                    </div>
                </div>
            </div>
            <div class="form-group pt-3">
                <div class="form-row">
                    <div class="col-md-6">
                        <input class="btn btn-primary btn-block" type="submit" value="Save">
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-success btn-block" href="{{route('products.index')}}">Back</a>
                    </div> 
                </div>
            </div>
        </div> <!--./card body-->

    </div> <!--./card card-register mx-auto mt-5-->
</form>
</div>


@include('includes.display_form_errors')


@stop