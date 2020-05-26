<!-- 
    Author:     Alvah Amit Halder
    Document:   Countries edit blade.
    Model/Data: App\Country
    Controller: CountriesController
-->

@extends('theme.default')

@section('title', __('VSF-Countries'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Update or Delete Country'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Edit Country</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<h1>Hi!! you can edit/update your countries here.</h1><hr>
<div class="card card-register mx-auto mt-5">
    <div class="card-header">Update country</div>
    <div class="card-body">
        <form method="POST" action="{{route('countries.update', $country->id)}}" accept-charset="UTF-8">
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
                        value="{{old('name', $country->name)}}"
                        required="required"
                    >
                    <label for="name">Type in new country name</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="text" 
                        name="code" 
                        id="code" 
                        class="form-control" 
                        placeholder="Country code" 
                        value="{{old('code',$country->code)}}"
                    >
                    <label for="code">Type in a code for the country</label>
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
                        <form method="POST" action="{{route('countries.destroy', $country->id)}}" accept-charset="UTF-8">
                            {{method_field('DELETE')}}
                            @csrf
                            <input class="btn btn-danger btn-block" type="submit" value="Delete">
                            </div> 
                        </form>
                        <div class="col-md-4">
                            <a class="btn btn-success btn-block" href="{{route('countries.index')}}">Back</a>
                        </div> 
                    </div>
                </div>
        @include('includes.display_form_errors')
    </div>
</div>
@stop