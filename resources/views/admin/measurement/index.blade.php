<!-- 
    Author:     Alvah Amit Halder
    Document:   Measurements' Index blade.
    Model/Data: App\Measurement
    Controller: MeasurementsController
-->

@extends('theme.default')

@section('title', __('VSF-Units'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('List of Measurement Units'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Measurements</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>

<!--<h1>Hi!! I found following measure units:</h1>-->
<!--Add new button-->
<div class="form-group text-right">
    <a class="btn btn-primary right" href="{{route('measurements.create')}}">Add new</a>
</div> 
<!--Data table-->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Measurement Units Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Unit</th>
                        <th>Short Code</th>
                        <th>Used for</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Unit</th>
                        <th>Short Code</th>
                        <th>Used for</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td><a href="{{route('measurements.edit', $item->id)}}">{{$item->unit}}</a></td>
                        <td>{{$item->short}}</td>
                        <td>{{$item->used_for}}</td>
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