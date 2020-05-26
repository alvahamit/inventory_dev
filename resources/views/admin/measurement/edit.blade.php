<!-- 
    Author:     Alvah Amit Halder
    Document:   Measurements' edit blade.
    Model/Data: App\Measurement
    Controller: MeasurementsController
-->

@extends('theme.default')

@section('title', __('VSF-Units'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Update or Delete Measurement Unit'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Update Measurement</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<!--<h1>Hi!! you can edit/update measurement units here.</h1><hr>-->
<div class="card card-register mx-auto mt-5">
    <div class="card-header">Update measurement unit</div>
    <div class="card-body">
        <form method="POST" action="{{route('measurements.update',$data->id)}}" accept-charset="UTF-8">
            {{method_field('PATCH')}}
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
                        value="{{old('unit',$data->unit)}}"
                        required="required">
                    <label for="unit">Edit measure unit name.</label>
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
                        value="{{old('short',$data->short)}}"
                        required="required">
                    <label for="short">Edit short code of measure unit.</label>
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
                        value="{{old('used_for',$data->used_for)}}"
                        required="required">
                    <label for="used_for">Edit what this measure unit is used for.</label>
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
                        <form method="POST" action="{{route('measurements.destroy', $data->id)}}" accept-charset="UTF-8">
                            {{method_field('DELETE')}}
                            @csrf
                            <input class="btn btn-danger btn-block" type="submit" value="Delete">
                            </div> 
                        </form>
                        <div class="col-md-4">
                            <a class="btn btn-success btn-block" href="{{route('measurements.index')}}">Back</a>
                        </div> 
                    </div>
                </div>
        @include('includes.display_form_errors')
    </div>
</div>
@stop