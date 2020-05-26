<!-- 
    Author:     Alvah Amit Halder
    Document:   Roles' create blade.
    Model/Data: App\Role
    Controller: RoleController
-->

@extends('theme.default')

@section('title', __('VSF-Roles'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Create User Roles'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Create Role</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<!--<h3>Hi!! you can register new roles for users here.</h3>
<hr>-->
<div class="card card-register mx-auto mt-5">
    <div class="card-header">Register new role</div>
    <div class="card-body">
        <form method="POST" action="{{route('roles.store')}}" accept-charset="UTF-8">
            @csrf
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control" 
                        placeholder="Role name" 
                        autofocus="autofocus" 
                        value="{{old('name')}}"
                        required="required"
                    >
                    <label for="name">Type in new role name</label>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Type in new role description (optional):</label>
                    <textarea
                        type="text" 
                        name="description" 
                        id="description" 
                        class="form-control" 
                        value=""
                        rows="3">{{old('description')}}</textarea>
            </div>
            <!--<input class="btn btn-primary btn-block" type="submit" value="Register">-->
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <input class="btn btn-primary btn-block" type="submit" value="Save">
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-success btn-block" href="{{route('roles.index')}}">Back</a>
                    </div> 
                </div>
            </div>
        </form>

        @include('includes.display_form_errors')
    </div>
</div>
@stop