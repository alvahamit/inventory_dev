<!-- 
    Author:     Alvah Amit Halder
    Document:   Roles' edit blade.
    Model/Data: App\Role
    Controller: RoleController
-->

@extends('theme.default')

@section('title', __('VSF-Roles'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Update or Delete User Roles'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Update Role</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<!--<h3>Hi!! you can update roles for users here.</h3>
<hr>-->
<div class="card card-register mx-auto mt-5">
    <div class="card-header">Update role</div>
    <div class="card-body">
        <form method="POST" action="{{route('roles.update', $data->id)}}" accept-charset="UTF-8">
            {{method_field('PATCH')}}
            @csrf
            <div class="form-group">
                <label for="name">Role Name:</label>
                <input type="text" name="name" id="name" class="form-control" autofocus="autofocus" value="{{old('name', $data->name)}}" required="required">
            </div>
            <div class="form-group">
                <label for="description">Role Description (optional):</label>
                <textarea type="text" name="description" id="description" class="form-control" rows="3">{{old('description', $data->description)}}</textarea>
            </div>
            
            <!--Buttons with separate form for delete-->
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <input class="btn btn-primary btn-block" type="submit" value="Save">
                    </div> 
                    </form>
                    <div class="col-md-6">
                        <form method="POST" action="{{route('roles.destroy', $data->id)}}" accept-charset="UTF-8">
                            {{method_field('DELETE')}}
                            @csrf
                            <input class="btn btn-danger btn-block" type="submit" value="Delete">
                            </div> 
                        </form>
                    </div>
                </div>
        @include('includes.display_form_errors')
    </div>
</div>
@stop