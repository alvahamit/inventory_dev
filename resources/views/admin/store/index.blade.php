<!-- 
    Author:     Alvah Amit Halder
    Document:   Stores Index blade.
    Model/Data: App\Store
    Controller: StoresController
-->

@extends('theme.default')

@section('title', __('VSF-Stores'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('List of Stores'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Stores</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>

<!--<h1>Hi!! I found following stores:</h1>-->
<!--Add new button-->
<div class="form-group text-right">
    <a class="btn btn-primary right" href="{{route('stores.create')}}">Add new</a>
</div> 
<!--Data table-->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Stores Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Location</th>
                        <th>Contact</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Location</th>
                        <th>Contact</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td><a href="{{route('stores.edit', $item->id)}}">{{$item->name}}</a></td>
                        <td>{{$item->address}}</td>
                        <td>{{$item->location}}</td>
                        <td>{{$item->contact_no}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>{{$item->updated_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated {{now()->format('g:i a l jS F Y')}}</div>
</div>
@stop