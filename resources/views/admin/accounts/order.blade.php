<!-- 
    Author:     Alvah Amit Halder
    Document:   Orders Index blade for Accounts.
    Model/Data: App\Order
    Controller: OrdersController@ordersForAcc
-->

@extends('theme.default')

@section('title', __('VSF-Accounts'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Approved Orders for Accounts'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">Orders</li>
</ol>


<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Order Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Reference</th>
                        <th>Received on</th>
                        <th>Customer</th>
                        <th>Qty. Type</th>
                        <th>Total</th>
                        <th>Invoiced?</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Reference</th>
                        <th>Received on</th>
                        <th>Customer</th>
                        <th>Qty. Type</th>
                        <th>Total</th>
                        <th>Invoiced?</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>

@stop

@section('scripts')
<script type="text/javascript">
// Shorthand for $( document ).ready()
$(function() {
    /*
     * Initialize Yajra on document table.
     */
    $('#dataTable').DataTable({
        processing: true,
        servirSide: true,
        ajax: {
            url: "{{ route('orders.for.accounts') }}",
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'order_no', name: 'order_no'},
            {data: 'order_date', name: 'order_date'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'quantity_type', name: 'quantity_type'},
            {data: 'order_total', name: 'order_total'},
            {data: 'is_invoiced', name: 'is_invoiced'},
            {data: 'order_status', name: 'order_status'},
            {data: 'action', name: 'action'},
        ],
        order:[[0, "desc"]],
        columnDefs: [
            {
                "targets": 8, // Count starts from 0.
                "className": "text-center",
                "width": "auto"
            },
        ],
    });
    
}); //End

</script>
@stop
    