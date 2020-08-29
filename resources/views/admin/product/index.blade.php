<!-- 
    Author:     Alvah Amit Halder
    Document:   Product's Index blade.
    Model/Data: App\Product
    Controller: ProductsController
-->

@extends('theme.default')

@section('title', __('VSF-Products'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('List of Products'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">Products</li>
</ol>
@include('errors.myerrormsg')
@include('errors.mysuccessmsg')
<!--Add new button-->
<div class="form-group text-right d-print-none">
    <a class="btn btn-primary right" href="{{route('products.create')}}">Add new</a>
</div> 
<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Products Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Brand</th>
                        <th>Country of Origin</th>
                        <th>Packing</th>
                        <th>Sales price</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Brand</th>
                        <th>Country of Origin</th>
                        <th>Packing</th>
                        <th>Sales price</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td><a href="{{route('products.edit', $item->id)}}">{{$item->name}}</a></td>
                        <td>{{$item->description}}</td>
                        <td>{{$item->brand}}</td>
                        <td>{{$item->country->name}}</td>
                        @if(!empty($item->packings->first()))
                        <td>
                            {{ 
                                $item->packings()->first()->name.", "
                                .$item->packings()->first()->quantity
                                .$item->units()->first()->short." x "
                                .$item->packings()->first()->multiplier 
                                
                            }}
                        </td>
                        <td>{{'Tk. '.number_format($item->packings()->first()->price,2)}}</td>
                        @else
                        <td style="color: red">Packing not defined.</td>
                        <td style="color: red">{{0.00}}</td>
                        @endif
                        <td>{{ !empty($item->created_at) ? $item->created_at->diffForHumans() : ''}}</td>
                        <td>{{ !empty($item->updated_at) ? $item->updated_at->diffForHumans() : ''}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated {{$lastUpdated}}</div>
</div>
@stop