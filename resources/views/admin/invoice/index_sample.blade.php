<!-- 
    Author:     Alvah Amit Halder
    Document:   Invoice index blade.
    Model/Data: App\Invoice
    Controller: InvoicesController
-->

@extends('theme.default')

@section('title', __('VSF-Invoice'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('List of Invoice'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">Sample Invoices</li>
</ol>

<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Sample Invoice Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="invoiceDataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Invoice No</th>
                        <th>Order No</th>
                        <th>Invoice Date</th>
                        <th>Billed to</th>
                        <th>Qty Type</th>
                        <th>Invoiced Amt.</th>
                        <th>Invoice Type</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01</td>
                        <td>INV_001</td>
                        <td>12-2-20</td>
                        <td>Whole</td>
                        <td>Company XYZ</td>
                        <td>Tk. 45000.00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Invoice No</th>
                        <th>Order No</th>
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

@stop

@section('scripts')

<script type="text/javascript">
$(document).ready(function(){
    /*
    * Initialize Yajra on invoice data table.
    */
    $('#invoiceDataTable').DataTable({
        processing: true,
        servirSide: true,
        ajax: {
            url: '{{ route("sample.invoice.index") }}',
            //success: function(data){ console.log(data); },
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'invoice_no', name: 'invoice_no'},
            {data: 'order_no', name: 'order_no'},
            {data: 'invoice_date', name: 'invoice_date'},
            {data: 'billed_to', name: 'billed_to'},
            {data: 'quantity_type', name: 'quantity_type'},
            {data: 'invoice_total', name: 'invoice_total'},
            {data: 'invoice_type', name: 'invoice_type'},
        ],
        order:[[0, "desc"]],
   })
   
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
                            $('#invoiceDataTable').DataTable().ajax.reload();
                            //alert('Invoice no. '+data.invoice+' deleted.');
                            bootbox.alert({
                                size: "small",
                                title: "Deleted...",
                                message: "Invoice no. "+data.invoice+" deleted.",
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
                    $('#modalForm').trigger("reset");
                    $('#deleteBtn').html('Delete');
                    $('#ajaxModel').modal('hide');
                }
              }
            }
          }) //Confirm Box
    }) //Delete Icon Click end.
    
    /*
    * Datatable Edit icon click:
    * Editing Order.
    */
    $('#invoiceDataTable').on('click', 'a.text-warning.edit', function (e) {
        e.preventDefault();
        bootbox.alert({
            size: "small",
            title: "Opps!!!",
            message: "This functionality is not written yet! <br> If you need this CRY out to your developer.",
            backdrop: true
        });
    })
   

});
    
</script>

@stop