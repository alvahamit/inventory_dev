<!-- 
    Author:     Alvah Amit Halder
    Document:   Roles' Index blade.
    Model/Data: App\Role
    Controller: RoleController
-->

@extends('theme.default')

@section('title', __('VSF-Roles'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('List of User Roles'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Roles</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<!--<h3>Hi!! I found following user roles defined:</h3>-->
<!--Add new button-->
<div class="form-group text-right">
    <a class="btn btn-primary right" href="{{route('roles.create')}}">Add new</a>
</div> 
<!--Data table-->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Roles Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td><a href="{{route('roles.edit',$role->id)}}">{{$role->name}}</a></td>
                        <td>{{$role->description}}</td>
                        <td>{{!empty($role->created_at) ? $role->created_at->diffForHumans() : ''}}</td>
                        <td>{{!empty($role->updated_at) ? $role->updated_at->diffForHumans() : ''}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated {{now()->format('g:i a l jS F Y')}}</div>
</div>
@stop