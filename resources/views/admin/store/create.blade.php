<!-- 
    Author:     Alvah Amit Halder
    Document:   Stores create blade.
    Model/Data: App\Store
    Controller: StoresController
-->

@extends('theme.default')

@section('title', __('VSF-Stores'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Create Store'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Register Store</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<!--<h1>Hi!! you can register new stores here.</h1><hr>-->
<div class="card card-register mx-auto mt-5">
    <div class="card-header">Register new store</div>
    <div class="card-body">
        <form method="POST" action="{{route('stores.store')}}" accept-charset="UTF-8">
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
                        value="{{old('name')}}"
                        required="required">
                    <label for="name">Type in new store name</label>
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
                        value="{{old('address')}}"
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
                        value="{{old('location')}}"
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
                        value="{{old('contact_no')}}"
                        required="required">
                    <label for="contact_no">Type a contact no. for the store</label>
                    <small>Format: 017XXXXXXXX</small>
                </div>
            </div>
            <!--<input class="btn btn-primary btn-block" type="submit" value="Register">-->
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <input class="btn btn-primary btn-block" type="submit" value="Save">
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-success btn-block" href="{{route('stores.index')}}">Back</a>
                    </div> 
                </div>
            </div>
        </form>
        @include('includes.display_form_errors')
    </div>
</div>
@stop