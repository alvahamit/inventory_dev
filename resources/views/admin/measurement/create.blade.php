<!-- 
    Author:     Alvah Amit Halder
    Document:   Measurements' create blade.
    Model/Data: App\Measurement
    Controller: MeasurementsController
-->

@extends('theme.default')

@section('title', __('VSF-Units'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Create Measurement Unit'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Register Measurement</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<!--<h1>Hi!! you can register new measurement units here.</h1><hr>-->
<div class="card card-register mx-auto mt-5">
    <div class="card-header">New measurement unit</div>
    <div class="card-body">
        <form method="POST" action="{{route('measurements.store')}}" accept-charset="UTF-8">
            @csrf
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="text" 
                        name="unit" 
                        id="unit" 
                        class="form-control" 
                        placeholder="Unit name" 
                        autofocus="autofocus" 
                        value="{{old('unit')}}"
                        required="required">
                    <label for="unit">Type in new measure unit name.</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="text" 
                        name="short" 
                        id="short" 
                        class="form-control" 
                        placeholder="Short code" 
                        value="{{old('short')}}"
                        required="required">
                    <label for="short">Type in a short code of measure unit.</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="text" 
                        name="used_for" 
                        id="used_for" 
                        class="form-control" 
                        placeholder="Description" 
                        value="{{old('used_for')}}"
                        required="required">
                    <label for="used_for">Type in a what this measure unit is used for.</label>
                </div>
            </div>
            <!--<input class="btn btn-primary btn-block" type="submit" value="Register">-->
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <input class="btn btn-primary btn-block" type="submit" value="Save">
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-success btn-block" href="{{route('measurements.index')}}">Back</a>
                    </div> 
                </div>
            </div>
        </form>
        @include('includes.display_form_errors')
    </div>
</div>
@stop