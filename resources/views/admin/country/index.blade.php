<!-- 
    Author:     Alvah Amit Halder
    Document:   Countries Index blade.
    Model/Data: App\Country
    Controller: CountriesController
-->

@extends('theme.default')

@section('title', __('VSF-Countries'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('List of Countries'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Countries</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>

<!--<h1>Hi!! I found following countries:</h1>-->
<!--Add new button-->
<div class="form-group text-right">
    <a class="btn btn-primary right" href="{{route('countries.create')}}">Add new</a>
</div> 
<!--Data table-->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Countries Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td><a href="{{route('countries.edit', $item->id)}}">{{$item->name}}</a></td>
                        <td>{{$item->code}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>{{$item->updated_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="dataTables_paginate paging_simple_numbers offset-4" id="dataTable_paginate">
                {{$data->render()}}
            </div>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated {{now()->format('g:i a l jS F Y')}}</div>
</div>
@stop