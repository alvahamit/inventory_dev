@extends('layouts.admin')
@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Users</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<h1>Hi!! I found following suppliers for you:</h1>
<!--Add new button-->
<div class="form-group text-right">
    <a class="btn btn-primary right" href="{{route('suppliers.create')}}">Add new</a>
</div> 
<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Suppliers Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td><a href="{{route('suppliers.edit',$item->id)}}">{{$item->name}}</a></td>
                        <td>{{$item->email}}</td>
                        @if($item->role->count() > 0)
                        @foreach ($item->role as $r)
                        <td>{{$r->name }}</td>
                        @endforeach
                        @else
                        <td style="color:red">Unassigned</td>
                        @endif
                        <td>{{$item->created_at->diffForHumans()}}</td>
                        <td>{{$item->updated_at->diffForHumans()}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>




@stop