<!-- 
    Author:     Alvah Amit Halder
    Document:   Sample Show Blade (with Tabbed navigation: Sample(Invoice)>Challan). 
    Model/Data: App\Invoice, App\Challan
    Controller: InvoiceController, ChallanController
-->

@extends('theme.default')

@section('title', __('VSF-Sample Processing'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Sample Processing'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('samples.index') }}">Samples</a>
    </li>
    <li class="breadcrumb-item active">{{$order->order_no}}</li>
</ol>

<!-- Tab Heads -->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a href="#order" class="nav-link active" data-toggle="tab">Request</a>
    </li>
    <li class="nav-item">
        <a href="#invoice" class="nav-link" data-toggle="tab">Invoice</a>
    </li>
    <li class="nav-item">
        <a href="#challan" class="nav-link" data-toggle="tab">Challan</a>
    </li>
</ul>

<div class="tab-content">
    <!--Markup for Order-->
    <input type="hidden" id="order_id" value="{{$order->id}}">
    <div class="tab-pane fade show active" id="order">
        <form method="post" action="{{route('print.order')}}" accept-charset="UTF-8">
            @csrf
            <input type="hidden" name="id" value="{{$order->id}}">
            <button type="submit" class="btn btn-primary float-right mr-1"><i class="far fa-file-pdf fa-lg"></i> PDF</button>
        </form>
        <h4 class="mt-2 pt-1 pb-2">
            Date: {{$order->order_date}}
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-6 float-xs-right float-left text-md-left"></div>
                    <div class="col-xs-12 col-md-6 col-lg-6 float-xs-right float-right text-md-right"><strong>Order#:</strong> {{$order->order_no}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-6 float-xs-left float-left text-md-left">
                        <strong>Billing Address:</strong><br>
                        {{$order->customer_name}}<br>
                        {{$order->customer_company}}<br>
                        {{$order->customer_address}}<br>
                        <i class="fas fa-phone-square-alt"></i> {{$order->customer_contact}}<br>
                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-6 float-xs-right float-right text-md-right">
                        <strong>Shipping Address:</strong><br>
                        {{$order->shipp_to_name}}<br>
                        {{$order->shipp_to_company}}<br>
                        {{$order->shipping_address}}<br>
                        <i class="fas fa-phone-square-alt"></i> {{$order->shipping_contact}}<br>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h3 class="text-xs-center"><strong>Order Details</strong></h3>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <td><strong>Item Name</strong></td>
                                        <td><strong>Unit</strong></td>
                                        <td class="text-xs-center"><strong>Unit Price</strong></td>
                                        <td class="text-xs-center"><strong>Quantity</strong></td>
                                        <td class="text-xs-right"><strong>Total</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->products->all() as $item)
                                    <tr>
                                        <td>{{$item->pivot->product_name}}</td>
                                        @if(!empty($order->quantity_type))
                                        <td class="text-xs-center">{{$order->quantity_type}}</td>
                                        @else
                                        <td class="text-xs-center">{{$item->pivot->product_packing}}</td>
                                        @endif
                                        <td class="text-xs-center">{{ "Tk. ".number_format($item->pivot->unit_price,2) }}</td>
                                        @if(!empty($order->quantity_type))
                                        <td class="text-xs-center">{{$item->pivot->quantity}} {{$item->itemStock($order->quantity_type)['unit']}}</td>
                                        @else
                                        <td class="text-xs-center">{{$item->pivot->quantity}} {{$item->itemStock()['unit']}}</td>
                                        @endif
                                        <td class="text-xs-right">{{ "Tk. ".number_format($item->pivot->item_total,2) }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow text-xs-center"><strong>Others</strong></td>
                                        <td class="emptyrow text-xs-right">-</td>
                                    </tr>
                                    <tr>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow text-xs-center"><strong>Total</strong></td>
                                        <td class="emptyrow text-xs-right">{{ "Tk. ".number_format($order->order_total,2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row pt-2">
            <div class="col-md-12">
                <details>
                    @if($order->isInvoiced())
                    <summary>Samples has been invoiced. ({{count($order->invoices)}} Invoice/s)</summary>
                    <ul>
                        @foreach($order->invoices as $invoice)
                        @php
                        if($invoice->invoice_type == config('constants.invoice_type.whole')){$invoice_type = 'Whole';}
                        if($invoice->invoice_type == config('constants.invoice_type.partial')){$invoice_type = 'Partial';}
                        if($invoice->invoice_type == config('constants.invoice_type.sample')){$invoice_type = 'Sample';}
                        @endphp
                        <li>Invoiced on {{$invoice->invoice_date}}, Type: {{$invoice_type ?? ''}}, Total: {{"Tk. ".number_format($invoice->invoice_total,2)}}</li>
                        @endforeach
                    </ul>    
                    @else
                    <summary style="color:red">Sample/s never been invoiced.</summary>
                    @endif
                </details>
                <details>
                    @if($order->order_status == "pending")
                    <summary style="color:red">Sample request is {{$order->order_status}}.</summary>
                    @else
                    @if($order->order_status == "complete")
                    <summary style="color:green">Sample request is {{$order->order_status}}. ({{count($order->challans)}} Challan/s)</summary>
                    @else
                    <summary>Sample request is {{$order->order_status}}. ({{count($order->challans)}} Challan/s)</summary>
                    @endif
                    <ul>
                        @foreach($order->challans as $challan)
                        <li>Challan Issued on {{$challan->challan_date}} delivered from {{$challan->store_name}}.</li>
                        @endforeach
                    </ul>
                    @endif
                </details>
            </div>
        </div>
    </div>
    <!--End of Markup for Order-->
    
    <!--Markup for Invoice-->
    <div class="tab-pane fade" id="invoice">
        <h4 class="mt-2">Issued Invoices</h4>
        <!--Add new button-->
        <div class="form-group text-right">
            <a class="btn btn-primary right" href="{{route('create.invoice',$order->id)}}">New Invoice</a>
        </div> 
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header"><i class="fas fa-table"></i> Invoice Data Table </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="invoiceDataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Invoice No</th>
                                <th>Invoice Date</th>
                                <th>Billed to</th>
                                <th>Qty Type</th>
                                <th>Invoiced Amt.</th>
                                <th>Invoice Type</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Invoice No</th>
                                <th>Invoice Date</th>
                                <th>Billed to</th>
                                <th>Qty Type</th>
                                <th>Invoiced Amt.</th>
                                <th>Invoice Type</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
    </div>
    <!--End of Markup for Invoice-->
    <!--Markup for Challan-->
    <div class="tab-pane fade" id="challan">
        <h4 class="mt-2">Issued Challan</h4>
        <!--Add new button-->
        <div class="form-group text-right">
            <a class="btn btn-primary right" href="{{route('order.challan.create', $order->id)}}">New Challan</a>
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
                                <th>Challan Date</th>
                                <th>Customer Name</th>
                                <th>Products</th>
                                <th>Qty. Type</th>
                                <th>Delivered From</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>01</td>
                                <td>INV_001</td>
                                <td>12-2-20</td>
                                <td>BADC</td>
                                <td>Company XYZ</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Challan No</th>
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
    </div>
    <!--End Markup for Challan-->
</div> <!--./tab-content-->

<style>
.card{margin-top: 10px}
.card .card-block{padding: 8px}
.height {
    min-height: 200px;
}

.icon {
    font-size: 47px;
    color: #5CB85C;
}

.iconbig {
    font-size: 77px;
    color: #5CB85C;
}

.table > tbody > tr > .emptyrow {
    border-top: none;
}

.table > thead > tr > .emptyrow {
    border-bottom: none;
}

.table > tbody > tr > .highrow {
    border-top: 3px solid;
}
</style>
@stop

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
        
    /*
    * Initialize Yajra on invoice data table.
    */
    var orderID = $('#order_id').val();
    $('#invoiceDataTable').DataTable({
        processing: true,
        servirSide: true,
        ajax: {
            data:{'order_id':orderID},
            url: '{{ route("invoices.index.by.order") }}',
            //success: function(data){ console.log(data); },
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'invoice_no', name: 'invoice_no'},
            {data: 'invoice_date', name: 'invoice_date'},
            {data: 'billed_to', name: 'billed_to'},
            {data: 'quantity_type', name: 'quantity_type'},
            {data: 'invoice_total', name: 'invoice_total'},
            {data: 'invoice_type', name: 'invoice_type'}
        ],
        order:[[0, "desc"]]
   });
   
   
    /*
    * invoiceDataTable Delete icon click:
    * Deleting Order.
    */
    $('#invoiceDataTable').on('click', 'a.text-danger.delete', function (e){
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
                    var action = '{{ route("invoices.index") }}/'+id;
                    var method = 'DELETE';
                    $.ajax({
                        data: {"_token": "{{ csrf_token() }}"},
                        url: action,
                        type: method,
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            //$('#invoiceDataTable').DataTable().ajax.reload();
                            bootbox.alert({
                                size: "small",
                                title: "Deleted...",
                                message: "Invoice no. "+data.invoice+" deleted.",
                                backdrop: true,
                                callback: function () {
                                    location.reload(true);
                                    //setTimeout(function(){location.reload()}, 3000);
                                }
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
                    $('#modalForm').trigger("reset");
                    $('#deleteBtn').html('Delete');
                    $('#ajaxModel').modal('hide');
                }
              }
            }
          }); //Confirm Box
    }); //Delete Icon click end.
   
   /*
    * Initialize Yajra on challan data table.
    * var orderID already decalred above.
    */
    $('#challanDataTable').DataTable({
        processing: true,
        servirSide: true,
        ajax: {
            data:{'order_id':orderID},
            url: '{{ route("challans.index.by.order") }}',
            //success: function(data){ console.log(data); },
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'challan_no', name: 'challan_no'},
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
                            //$('#challanDataTable').DataTable().ajax.reload();
                            bootbox.alert({
                                size: "small",
                                title: "Deleted...",
                                message: "Delivery challan <strong>"+data.challan.toUpperCase()+"</strong> deleted.",
                                backdrop: true,
                                callback: function () {
                                    location.reload(true);
                                    //setTimeout(function(){location.reload()}, 3000);
                                }
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
          }); //Confirm Box
    }); //Delete Icon click end.
   

});
    
</script>
@stop