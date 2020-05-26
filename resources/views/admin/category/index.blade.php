<!-- 
    Author:     Alvah Amit Halder
    Document:   Categories Index blade.
    Model/Data: App\Category
    Controller: CategoryController
-->

@extends('theme.default')

@section('title', __('VSF-Category'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('List of Categories'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dash') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Categories</li>
</ol>
<!--<h1>Hi!! I have found following categories:</h1>-->
<!--Add new button-->
<div class="form-group text-right">
    <a class="btn btn-primary right" href="{{route('categories.create')}}">Add new</a>
</div> 
<!--Data table-->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Categories Data Table </div>
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
                    @foreach ($data as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td><a href="{{route('categories.edit',$item->id)}}">{{$item->name}}</a></td>
                        <td>{{$item->description}}</td>
                        <td>{{!empty($item->created_at) ? $item->created_at->diffForHumans() : ''}}</td>
                        <td>{{!empty($item->updated_at) ? $item->updated_at->diffForHumans() : ''}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated {{now()->format('g:i a l jS F Y')}}</div>
</div>
@stop