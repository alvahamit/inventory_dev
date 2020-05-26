@extends('layouts.admin')
@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Stock</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<h1>Hi!! here is your stock status now:</h1>
<!--Add new button-->
<div class="form-group text-right">
    <form method="POST" action="">
        @csrf
        <div class="form-row ">
            <select class="right">
                <option value="">Select one...</option>
                <option value="pcs">Stock by unit</option>
                <option value="weight">Stock by weight</option>
            </select>
            <input class="btn btn-primary right" type="submit" value="Submit">
        </div>
    </form>
</div> 
<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Stock Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Country</th>
                        <th scope="col">Packing</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stock</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Country</th>
                        <th scope="col">Packing</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stock</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td><a href="#">{{$item->name}}</a></td>
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
                        <td>{{$item->packings()->first()->price}}</td>
                        @else
                        <td style="color: red">Packing not defined.</td>
                        <td style="color: red">{{0.00}}</td>
                        @endif
                        <!--<td>{{ $item->itemStock('pcs')['qty']." ".$item->itemStock('pcs')['unit'] }}</td>-->
                        <!--<td>{{ $item->itemStock('weight')['qty']." ".$item->itemStock('weight')['unit'] }}</td>-->
                        <td>{{ $item->itemStock()['qty']." ".$item->itemStock()['unit'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>
@stop