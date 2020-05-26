@extends('layouts.admin')
@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Purchases</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<h1>Hi!! you have made following purchases:</h1>
<!--Add new button-->
<div class="form-group text-right">
    <a class="btn btn-primary right" href="{{route('purchases.create')}}">Add new</a>
</div> 
<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Purchase Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Reference</th>
                        <th>Received on</th>
                        <th>Supplier</th>
                        <th>Type</th>
                        <th>Total</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Reference</th>
                        <th>Received on</th>
                        <th>Supplier</th>
                        <th>Type</th>
                        <th>Total</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td><a href="{{route('purchases.show',$item->id)}}">{{$item->ref_no}}</a></td>
                        <td>{{$item->receive_date}}</td>
                        <td>{{$item->user->name}}</td>
                        <td>{{$item->purchase_type}}</td>
                        <td>{{$item->total}}</td>
                        
                        <td>{{!empty($item->created_at) ? $item->created_at->diffForHumans() : ''}}</td>
                        <td>{{!empty($item->updated_at) ? $item->updated_at->diffForHumans() : ''}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>

@stop