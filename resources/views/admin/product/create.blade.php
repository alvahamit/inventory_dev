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
        <a href="{{ route('admin.dash') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Create Product</li>
</ol>
<!--<h1>Hi!! you can register new products here.</h1><hr>-->

<form method="POST" action="{{route('products.store')}}" accept-charset="UTF-8">
    @csrf
    <!--card-->
    <div class="card card-register mx-auto mt-5">
        <div class="card-header">General info.</div>
        <div class="card-body">    
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control" 
                        placeholder="Product name" 
                        autofocus="autofocus" 
                        value="{{old('name')}}"
                        required="required"
                        >
                    <label for="name">Type in new product name</label>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Type in new product description (optional):</label>
                <textarea
                    type="text" 
                    name="description" 
                    id="description" 
                    class="form-control" 
                    value="{{old('description')}}"
                    rows="3"></textarea>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="text" 
                        name="brand" 
                        id="brand" 
                        class="form-control" 
                        placeholder="Brand name" 
                        value="{{old('brand')}}"
                        required="required">
                    <label for="brand">Type in brand name, i.e. Puratos, Opai etc.</label>
                </div>
            </div>
            <div class="form-group">
                <label for="country_id">Country of origin:</label>
                <select class="form-control form-control-lg" name="country_id" required="required">
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
                <div class="form-label-group">
                    <input 
                        type="text" 
                        name="packing_name"
                        id="packing_name"
                        class="form-control" 
                        placeholder="Packing name" 
                        value="{{old('packing_name')}}"
                        required="required">
                    <label for="packing_name">Packing name. i.e. Corrugated box, paper bag, foil pack etc.</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control form-control-lg" name="measurement_id" required="required">
                                <option selected="selected" value="">Pick a unit...</option>
                                @foreach($units as $unit)
                                <option value="{{$unit->id}}">{{$unit->unit}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-label-group">
                            <input 
                                type="number" 
                                name="quantity" 
                                id="quantity" 
                                class="form-control" 
                                placeholder="Quantity" 
                                value="{{old('quantity')}}"
                                required="required">
                            <label for="quantity">Quantity</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-label-group">
                            <input 
                                type="number" 
                                name="multiplier" 
                                id="multiplier" 
                                class="form-control" 
                                placeholder="Multiplier" 
                                value="{{old('multiplier')}}"
                                required="required">
                            <label for="multiplier">x pcs / multiplier</label>
                        </div>
                    </div>
                </div> <!--./form-row-->
                <div class="form-label-group">
                    <input 
                        type="number" 
                        step="0.01"
                        name="price" 
                        id="price" 
                        class="form-control" 
                        placeholder="Selling price" 
                        value="{{old('price')}}"
                        required="required">
                    <label for="price">Selling price (BDT)...</label>
                </div>
            </div>
            <div class="form-group">
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

@include('includes.display_form_errors')


@stop