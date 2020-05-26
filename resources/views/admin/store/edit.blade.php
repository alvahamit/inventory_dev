<!-- 
    Author:     Alvah Amit Halder
    Document:   Stores create blade.
    Model/Data: App\Store
    Controller: StoresController
-->

@extends('theme.default')

@section('title', __('VSF-Stores'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Update or Delete Store'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Update Store</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<!--<h1>Hi!! you can update store information here.</h1><hr>-->
<div class="card card-register mx-auto mt-5">
    <div class="card-header">Register new store</div>
    <div class="card-body">
        <form method="POST" action="{{route('stores.update', $store->id)}}" accept-charset="UTF-8">
            {{method_field('PATCH')}}
            @csrf
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control" 
                        placeholder="Country name" 
                        autofocus="autofocus" 
                        value="{{old('name', $store->name)}}"
                        required="required">
                    <label for="name">Type in store name</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="text" 
                        name="address" 
                        id="address" 
                        class="form-control" 
                        placeholder="Address" 
                        value="{{old('address', $store->address)}}"
                        required="required">
                    <label for="address">Type in store address</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="text" 
                        name="location" 
                        id="location" 
                        class="form-control" 
                        placeholder="Store location" 
                        value="{{old('location', $store->location)}}"
                        required="required">
                    <label for="location">Type in store location</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="tel"
                        pattern="[0-9]{3}[0-9]{4}[0-9]{4}"
                        name="contact_no" 
                        id="contact_no" 
                        class="form-control" 
                        placeholder="Store contact" 
                        value="{{old('contact_no', $store->contact_no)}}"
                        required="required">
                    <label for="contact_no">Type a contact no. for the store</label>
                    <small>Format: 017XXXXXXXX</small>
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
                        <form method="POST" action="{{route('stores.destroy', $store->id)}}" accept-charset="UTF-8">
                            {{method_field('DELETE')}}
                            @csrf
                            <input class="btn btn-danger btn-block" type="submit" value="Delete">
                            </div> 
                        </form>
                        <div class="col-md-4">
                            <a class="btn btn-success btn-block" href="{{route('stores.index')}}">Back</a>
                        </div> 
                    </div>
                </div>
                @include('includes.display_form_errors')
            </div>
    </div>
    @stop