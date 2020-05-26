<!-- 
    Author:     Alvah Amit Halder
    Document:   Product's Edit blade.
    Model/Data: App\Product
    Controller: ProductsController@edit
-->

@extends('theme.default')

@section('title', __('VSF-Products'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Update or Delete Product'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dash') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('products.index') }}">Products</a>
    </li>
    <li class="breadcrumb-item active">Edit Product</li>
</ol>
<!--<h1>Okay!! you can now edit this product.</h1><hr>-->

<form method="POST" action="{{route('products.update', $product->id)}}" accept-charset="UTF-8">
    {{method_field('PATCH')}}
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
                        value="{{old('name',$product->name)}}"
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
                    rows="3">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="text" 
                        name="brand" 
                        id="brand" 
                        class="form-control" 
                        placeholder="Brand name" 
                        value="{{old('brand',$product->brand)}}"
                        required="required">
                    <label for="brand">Type in brand name, i.e. Puratos, Opai etc.</label>
                </div>
            </div>
            <div class="form-group">
                <label for="country_id">Country of origin:</label>
                <select class="form-control form-control-lg" name="country_id" required="required">
                    <option value="">Pick a country of origin...</option>
                    @foreach($countries as $country)
                        @if($country->id == $product->country->id)
                        <option selected="selected" value="{{$country->id}}">{{$country->name}}</option>
                        @else
                        <option value="{{$country->id}}">{{$country->name}}</option>
                        @endif
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
                        @if(!empty($product->packings->first()))
                        value="{{old('packing_name', $product->packings()->first()->name)}}"
                        @endif
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
                                    @if(!empty($product->units->first()) && $unit->id == $product->units()->first()->id)
                                    <option selected="selected" value="{{$unit->id}}">{{$unit->unit}}</option>
                                    @else
                                    <option value="{{$unit->id}}">{{$unit->unit}}</option>
                                    @endif
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
                                @if(!empty($product->packings->first()))
                                value="{{old('quantity', $product->packings()->first()->quantity)}}"
                                @endif
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
                                @if(!empty($product->packings->first()))
                                value="{{old('multiplier', $product->packings()->first()->multiplier)}}"
                                @endif
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
                        @if(!empty($product->packings->first()))
                        value="{{old('price', $product->packings()->first()->price)}}"
                        @endif
                        required="required">
                    <label for="price">Selling price (BDT)...</label>
                </div>
            </div>

            <!--Buttons with separate form for delete-->
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-4">
                        <input class="btn btn-primary btn-block" type="submit" value="Save">
                    </div> 
                    
                    </form>
                    <div class="col-md-4">
                        <form method="POST" action="{{route('products.destroy', $product->id)}}" accept-charset="UTF-8">
                            {{method_field('DELETE')}}
                            @csrf
                            <input class="btn btn-danger btn-block" type="submit" value="Delete">
                            </div> 
                        </form>
                        <div class="col-md-4">
                            <a class="btn btn-success btn-block" href="{{route('products.index')}}">Back</a>
                        </div> 
                    </div>
                </div>

        </div> <!--./card body-->
    </div> <!--./card card-register mx-auto mt-5-->




@include('includes.display_form_errors')


@stop