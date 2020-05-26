<!-- 
    Author:     Alvah Amit Halder
    Document:   Countries create blade.
    Model/Data: App\Country
    Controller: CountriesController
-->

@extends('theme.default')

@section('title', __('VSF-Countries'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Add New Country'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Register Country</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<!--<h1>Hi!! you can register new countries here.</h1><hr>-->
<div class="card card-register mx-auto mt-5">
    <div class="card-header">Register new country</div>
    <div class="card-body">
        <form method="POST" action="{{route('countries.store')}}" accept-charset="UTF-8">
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
                        value="{{old('code')}}"
                    >
                    <label for="code">Type in a code for the country</label>
                </div>
            </div>
            <!--<input class="btn btn-primary btn-block" type="submit" value="Register">-->
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <input class="btn btn-primary btn-block" type="submit" value="Save">
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-success btn-block" href="{{route('countries.index')}}">Back</a>
                    </div> 
                </div>
            </div>
        </form>
        @include('includes.display_form_errors')
    </div>
</div>
@stop