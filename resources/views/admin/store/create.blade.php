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
                <label for="name">Store Name:</label>
                <input type="text" name="name" id="name" class="form-control" autofocus="autofocus" value="{{old('name')}}" required="required">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea rows="3" class="form-control" name="address" id="address" required="required">{{old('address')}}</textarea>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" name="location" id="location" class="form-control" value="{{old('location')}}" required="required">
            </div>
            <div class="form-group">
                <label for="contact_no">Contact No:</label>
                <input type="tel"
                    pattern="[0-9]{3}[0-9]{4}[0-9]{4}"
                    name="contact_no" 
                    id="contact_no" 
                    class="form-control" 
                    value="{{old('contact_no')}}"
                    required="required">
                <small>Format: 017XXXXXXXX</small>
            </div>
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