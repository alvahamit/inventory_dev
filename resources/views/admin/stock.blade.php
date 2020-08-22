<!-- 
    Author:     Alvah Amit Halder
    Document:   Stockhausen blade.
    Model/Data: Nil
    Controller: Ajax/StockController
-->

@extends('theme.default')

@section('title', __('VSF-Stock'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Product Stock Status'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">Stock</li>
</ol>

<!--<h1>Hi!! Here is your stock status:</h1>-->
<!--Add additional filters-->
<div class="form-group text-right">
    <!--Store chooser-->
    <label class="" for="store-selector"> Store chooser: </label>
    <select id="store-selector" name="store-selector" class="custom-select col-md-2">
        <option value="">All Stores</option>
        @foreach ($stores as $store)
        <option value="{{$store->id}}">{{$store->name}}</option>
        @endforeach
    </select>
    <!--Format chooer-->
    <label class="" for="stock-formatter"> Format chooser: </label>
    <select id="stock-formatter" name="stock-formatter" class="custom-select col-md-2">
        <option value="">View by Packing</option>
        <option value="pcs">View by Unit/Pcs</option>
        <option value="weight">View by Weight</option>
    </select>
</div> 
<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Stock Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Country</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Stock</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Country</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Stock</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated {{$lastUpdated}}</div>
</div>
@stop

@section('scripts')
<!--Script for this page-->
<script type="text/javascript">
    /*
    * Datatable initialization function. 
    */
    function fill_datatable(formatter = '', store_id = ''){
        var dataTable = $('#dataTable').DataTable({
            processing: true,
            servirSide: true,
            ajax: {
                url: "{{ route('ajax-stock.index') }}",
                data: {'formatter':formatter, 'store_id': store_id},
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'brand', name: 'brand'},
                {data: 'country', name: 'country'},
                {data: 'price', name: 'price'},
                {data: 'stock', name: 'stock'},
            ]
        });
    };

   /*
    * Filter function: 
    */
    function filter_datatable(){
        var formatter = $('#stock-formatter').val();
        var store_id = $('#store-selector').val();
        $('#dataTable').DataTable().destroy();
        fill_datatable(formatter, store_id);
    }
    
    $(document).ready(function(){
        //Fill Datatable:
        fill_datatable();
        //Change Item Qty type:
        $('#stock-formatter').change(function(){
            filter_datatable();
        });
        //Change Store Stock:
        $('#store-selector').change(function(){
            filter_datatable();
        });
        
    }); //Document Ready function.
</script>
@stop