<!-- 
    Author:     Alvah Amit Halder
    Document:   Sample Challan Index blade.
    Model/Data: App\Challan
    Controller: ChallansController
-->

@extends('theme.default')

@section('title', __('VSF-Challans'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('List of Sample Challans'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">Sample Challan</li>
</ol>

<!--<h1>Hi!! you have following delivery challan issued:</h1>-->
<!--Add new button-->
<div class="form-group text-right">
    <!--<a class="btn btn-primary right" href="{{route('purchases.create')}}">Add new</a>-->
    <!--<button id="createNew" class="btn btn-primary col-1 right">New Order</button>-->
</div> 
<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Challan Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="challanDataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Challan No</th>
                        <th>Order No</th>
                        <th>Challan Date</th>
                        <th>Customer Name</th>
                        <th>Products</th>
                        <th>Qty. Type</th>
                        <th>Delivered From</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Challan No</th>
                        <th>Order No</th>
                        <th>Challan Date</th>
                        <th>Customer Name</th>
                        <th>Products</th>
                        <th>Qty. Type</th>
                        <th>Delivered From</th>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>

@stop

@section('scripts')
<!--Script for this page-->
<script type="text/javascript">

$(document).ready(function(){
    /*
    * Initialize Yajra on challan data table.
    * var orderID already decalred above.
    */
    $('#challanDataTable').DataTable({
        processing: true,
        servirSide: true,
        ajax: {
            url: '{{ route("sample.challan.index") }}',
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'challan_no', name: 'challan_no'},
            {data: 'order_no', name: 'order_no'},
            {data: 'challan_date', name: 'challan_date'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'transfer_items', name: 'transfer_items'},
            {data: 'quantity_type', name: 'quantity_type'},
            {data: 'store_name', name: 'store_name'}
        ],
        order:[[0, "desc"]]
   });
    
    /*
    * challanDataTable Delete icon click:
    * Deleting Challan.
    */
    $('#challanDataTable').on('click', 'a.text-danger.delete', function (e){
        e.preventDefault();
        var id = $(this).attr('href');
        // Confirm box
        bootbox.dialog({
            backdrop: true,
            //centerVertical: true,
            //size: '50%',
            closeButton: false,
            message: "Are you doing this by mistake? <br> If you confirm a record will be permantly deleted. Please confirm your action.",
            title: "Please confirm...",
            buttons: {
              success: {
                label: "Confirm",
                className: "btn-danger",
                callback: function() {
                    var action = '{{ route("challans.index") }}/'+id;
                    var method = 'DELETE';
                    $.ajax({
                        data: {"_token": "{{ csrf_token() }}"},
                        url: action,
                        type: method,
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            $('#challanDataTable').DataTable().ajax.reload();
                            bootbox.alert({
                                size: "small",
                                title: "Deleted...",
                                message: "Delivery challan <strong>"+data.challan.toUpperCase()+"</strong> deleted.",
                                backdrop: true,
                            });
                        },
                        error: function (data) {
                            console.log(data);
                            alert('Something is not right!!!');
                        }
                    }); // Ajax call
                }
              },
              danger: {
                label: "Cancel",
                className: "btn-success",
                callback: function() {
                    //$('#modalForm').trigger("reset");
                    $('#deleteBtn').html('Delete');
                    //$('#ajaxModel').modal('hide');
                }
              }
            }
          }) //Confirm Box
    }) //Delete Icon click end.





}); //Document ready function.
</script>
@stop