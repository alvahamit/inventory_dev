<!-- 
    Author:     Alvah Amit Halder
    Document:   Customer's Account Index blade.
    Model/Data: nil.
    Controller: CustomerAccountController
-->

@extends('theme.default')

@section('title', __('VSF-Customer Accounts'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Customers Account Status'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dash') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Customer Account</li>
</ol>

<!--<h1>Hi!! here are your customers account status:</h1>-->
<!--Add new button-->
<div class="form-group text-right">
    <!--<a class="btn btn-primary right" href="{{route('purchases.create')}}">Add new</a>-->
    <!--<button id="createNew" class="btn btn-primary col-1 right">Create New</button>-->
</div> 
<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Customer Account Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Customer</th>
                        <th>Company</th>
                        <th>Orders</th>
                        <th>Orders Amt.</th>
                        <th>Invoiced</th>
                        <th>Invoiced Amt.</th>
                        <th>Received Amt.</th>
                        <th>Completed</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Customer</th>
                        <th>Company</th>
                        <th>Orders</th>
                        <th>Orders Amt.</th>
                        <th>Invoiced</th>
                        <th>Invoiced Amt.</th>
                        <th>Received Amt.</th>
                        <th>Completed</th>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Customers' account status overview. </div>
</div>
@stop

@section('scripts')
<!--Script for this page-->
<script>
    /*
     * Document Ready function:
     * @param {type} e
     * @returns {undefined}
     */
    $(document).ready(function(){
        /*
         * Initialize Yajra on document table.
         * @param {type} e
         * @returns {undefined}
         */
        $('#dataTable').DataTable({
            processing: true,
            servirSide: true,
            ajax: {
                url: "{{ route('customers.account') }}",
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'company', name: 'company'},
                {data: 'orders', name: 'orders'},
                {data: 'orders_amt', name: 'orders_amt'},
                {data: 'invoiced', name: 'invoiced'},
                {data: 'invoice_amt', name: 'invoice_amt'},
                {data: 'received_amt', name: 'received_amt'},
                {data: 'completes', name: 'completes'},
            ],
            order:[[0, "desc"]],
        });
    });
</script>

@stop