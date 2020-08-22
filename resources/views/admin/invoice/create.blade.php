<!-- 
    Author:     Alvah Amit Halder
    Document:   Invoice create blade.
    Model/Data: App\Invoice
    Controller: InvoicesController
-->

@extends('theme.default')

@section('title', __('VSF-Invoice'))

@section('logo', __('VSF Distribution'))

@php
    switch ($order->order_type)
    {
        case config('constants.order_type.sales'):
            $type = 'Sales';
            $type_val = config('constants.order_type.sales');
            break;
        case config('constants.order_type.sample'):
            $type = 'Sample';
            $type_val = config('constants.order_type.sample');
            break;
        default:
            $type = 'Sales';
            $type_val = config('constants.order_type.sales');
    }
@endphp

@section('pageheading')
Create Invoice ({{$type}})
@stop

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<div class="container">
    <form name="invoiceForm" id="invoiceForm" action="#">
        <div id="form-errors" class="alert alert-warning"></div>
        @csrf
        <!--hidden id input-->
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="q_type" id="q_type">
        <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}">
        <input type="hidden" name="order_type" id="order_type" value="{{$order->order_type}}">
        <input type="hidden" name="customer_id" id="customer_id" value="{{$order->user_id}}">
        <div class="form-row col-md-12">
            <div class="form-group col-md-3">
                <label for="invoice_date">Invoice Date:</label>
                <input type="date" name="invoice_date" id="invoice_date" class="form-control form-control-sm">
            </div>
            <div class="form-group col-md-3 offset-md-6">
                <label for="invoice_no">Invoice No.:</label>
                <input type="text" name="invoice_no" id="invoice_no" class="form-control form-control-sm">
            </div>
        </div>
        <div class="form-row col-md-12">
            <div class="form-group col-md-3">
                @if($order->order_type == config('constants.order_type.sales'))
                <label for="order_no">Order No.:</label>
                @endif
                @if($order->order_type == config('constants.order_type.sample'))
                <label for="order_no">Request No.:</label>
                @endif
                <input type="text" name="order_no" id="order_no" class="form-control form-control-sm" readonly="readonly">
            </div>
            <div class="form-group col-md-3 offset-md-6">
                <label for="invoice_type">Invoice Type:</label>
                <select class="custom-select custom-select-sm" name="invoice_type" id="invoice_type">
                    @if($order->order_type == config('constants.order_type.sales'))
                    <option value="0">Choose...</option>
                    <option value="{{config('constants.invoice_type.whole')}}" selected="selected">Whole</option>
                    <option value="{{config('constants.invoice_type.partial')}}">Partial</option>
                    @endif
                    @if($order->order_type == config('constants.order_type.sample'))
                    <option value="0" selected>Choose...</option>
                    <option value="{{config('constants.invoice_type.sample')}}" selected="selected">Sample</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-row col-md-12">
            <div class="form-group col-md-6">
                <label for="invoiced_by">Invoiced By:</label>
                <textarea rows = "6" class="form-control form-control-sm" name = "invoiced_by" id = "invoiced_by" readonly="readonly">{!! auth()->user()->name!!}&#13;&#10;{!!config('constants.default_address')!!}</textarea>
            </div>
            <div class="form-group col-md-6">
                <label for="billed_to">Billed To:</label>
                <textarea rows = "6" class="form-control form-control-sm" name = "billed_to" id="billed_to" readonly="readonly"></textarea>
            </div>
        </div>

        <div class="form-row col-md-12 pt-2">
            <h5>Invoice Details: <span id="qty_type"></span></h5>
            
            <div class="table-responsive">
                <table class="table table-sm" id="items">
                    <thead>
                        <tr>
                            <th class="" style="width: 25%">Item Name</th>
                            <th class="text-center">Packing</th>
                            <th class="text-center">Unit Price</th>
                            <th class="text-center" style="width: 10%">Quantity</th>
                            <th class="text-right">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="summery">
                            <td colspan="4" class="text-right"><strong>Less Amount</strong></td>
                            <td class="text-right"><input type="number" min="0" name="discount" id="discount" class="form-control form-control-sm text-right"></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Carrying</strong></td>
                            <td class="text-right"><input type="number" min="0" name="carrying" id="carrying" class="form-control form-control-sm text-right"></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Other Charges</strong></td>
                            <td class="text-right"><input type="number" min="0" name="other_charge" id="other_charge" class="form-control form-control-sm text-right"></td>
                        </tr>
                        
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total Payable</strong></td>
                            <td class="text-right"><strong><input type="number" min="0" name="total" id="total" class="form-control form-control-sm text-right" readonly="readlonly"></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div> <!-- ./table-responsive -->
        </div> <!-- ./form-row -->
        <div class="form-row col-md-12 pt-2">
            <div class="form-group col-md-3 offset-md-3">
                <button class="btn btn-success form-control" id="saveBtn" value="store">Save</button>
            </div>
            <div class="form-group col-md-3">
                <button class="btn btn-primary form-control" id="closeBtn">Close</button>

            </div>
        </div>
    </form> 
</div> <!-- ./container -->

<style>
    label{
            margin-bottom: 0;
            padding-bottom: 0;
        }
    @media (max-width: 575px) {
        label{
            margin-bottom: 0;
            padding-bottom: 0;
        }
        div .form-row .col-md-12 {
            padding: 0;
        }
        div .form-row {
            padding: 0;
        }
        .container{
            padding: 0;
        }
        label{
            font-size: 0.8rem;
        }
    }
</style>
    

@stop

@section('scripts')

<script type="text/javascript">
/*
 * This calculates item subtotal.
 * @param {Number} row_no
 * @returns {Number}
 */
function subTotal(row_no){
    var sub_total = $('#item_qty' + row_no).prop('value') * $('#unit_price' + row_no).prop('value');
    return sub_total.toFixed(2);
}

/*
 * This calculates total payable amount.
 * @returns {Number}
 */
function totalPayable(){
    var sum = 0;
    var discount = 0;
    var carrying = 0;
    var other_charge;
    $('#discount').val() !== "" ? discount = $('#discount').val() : discount = 0;
    $('#carrying').val() !== "" ? carrying = $('#carrying').val() : carrying = 0;
    $('#other_charge').val() !== "" ? other_charge = $('#other_charge').val() : other_charge = 0;
    $('.item_total').each(function(){
        sum = + sum + + $(this).val();
    })
    return ((+ sum + + carrying + + other_charge) - discount).toFixed(2);
}

$(document).ready(function(){
    /*
     * Invoice Type Changer
     */
    $('#invoice_type').change(function(){
        if($.inArray($(this).val(), ['0', '1']) !== -1){
            $('.item_qty').attr('readonly', 'readonly');
            $('.close').attr('disabled', 'disabled');
        }
        if($(this).val() == 2){
            $('.item_qty').removeAttr('readonly');
            $('.close').removeAttr('disabled');
        }
    })
    /*
     * Calculations
     */
    $('#discount').keyup(function(){
        $('#total').val("");
        var total = totalPayable();
        $('#total').val(total);
    })
    $('#carrying').keyup(function(){
        $('#total').val("");
        var total = totalPayable();
        $('#total').val(total);
    })
    $('#other_charge').keyup(function(){
        $('#total').val("");
        var total = totalPayable();
        $('#total').val(total);
    })
    /*
     * Fillup Invoice form:
     * Get Order data to fill invoice.
     */
    var order_id = $('#order_id').val();
    var mehtod = 'GET';
    var action = '{{ route("get.order.for.invoice") }}';
    $.ajax({
        data: {'id': order_id},
        url: action,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log('Success:', data);
            var qt;
            data.order.quantity_type == null ? qt = 'packing' : qt = data.order.quantity_type;
            $('#qty_type').html('(Qty. by '+qt+')');
            $('#q_type').val(qt);
            $('#order_id').val(data.order.id);
            $('#order_no').val(data.order.order_no);
            $("#invoice_date").attr('min', data.order.unformated_order_date);
            $.get("{{ route('get.invoice.ref') }}", function (data) {
                $('#invoice_no').val(data);
            });
            $('#billed_to').val(data.order.customer_name+'\n'+data.order.customer_company+'\n'+data.order.customer_address+'\n'+data.order.customer_contact);
            //$('#invoiced_by').val('VSF Distribution\r\n7/1/A Lake Circus\nKolabagan, North Dhanmondi\r\nDhaka 1205');
            $(data.order.products).each(function(index, value){
                var row_count = $('#items tr').length - 5;
                var row_no = + row_count + 1;
                var trID = 'set' + row_no; //This is the table row ID for new row.
                var html = '<tr id="' + trID + '" class="set">' +
                        '<td><input type="text" name="item_name[]" id="item_name' + row_no + '" class="form-control form-control-sm" readonly="readonly" value="'+ value.name +'"></td>' +
                        '<input type="hidden" name="item_id[]" id="item_id' + row_no + '" value="'+ value.id +'">' +
                        '<td class="text-center"><input type="text" name="item_unit[]" id="item_unit' + row_no + '" class="form-control form-control-sm text-center" value="'+ value.pivot.product_packing +'" readonly="readonly"></td>'+
                        '<td class="text-center"><input type="text" name="unit_price[]" id="unit_price' + row_no + '" class="form-control form-control-sm text-right" value="'+ (value.pivot.unit_price).toFixed(2) +'" readonly="readonly"></td>'+
                        '<td class="text-center"><input type="number" name="item_qty[]" id="item_qty' + row_no + '" class="form-control form-control-sm text-center item_qty" value="'+ value.pivot.quantity +'" readonly="readonly"></td>'+
                        '<input type="hidden" name="invoicable_qty[]" id="invoicable_qty' + row_no + '" value="'+ value.pivot.quantity +'">' +
                        '<td class="text-right"><input type="text" name="item_total[]" id="item_total' + row_no + '" class="form-control form-control-sm item_total text-right" value="'+ (value.pivot.item_total).toFixed(2) +'" readonly="readonly"></td>'+
                        '<td><button id="remove' + row_no + '" type="button" class="close" data-dismiss="alert" disabled="disabled">&times;</button></td>' +
                        '</tr>';
                $('#summery').before(html);
                var total = totalPayable();
                $('#total').val(total);
            })
            
            /*
            * Removing Dynamic Rows 
            * and trigger change for recalculate.
            */
           $('.close').click(function(e){
               e.preventDefault();
               var el_id = event.target.id;
               var row_no = el_id.substr(6, );
               var trID = 'set' + row_no;
               $('#' + trID).remove();
               $('#total').val("");
               var total = totalPayable();
               $('#total').val(total);
           })
           /*
            * Subtotal on change of:
            * quantity. 
            */
           $('.item_qty').keyup(function(e){
               e.preventDefault();
               var el_id = event.target.id;
               var row_no = el_id.substr(8, );
               $('#item_total' + row_no).prop('value', subTotal(row_no));
               $('#total').val("");
               var total = totalPayable();
               $('#total').val(total);
           })
            
            $('#form-errors').hide();
            //$('#invoiceForm').trigger("reset");
            $('#saveBtn').html('Save');
            $('#shipping-address').attr("disabled", "disabled");
            //closeModal();
            //$('#dataTable').DataTable().ajax.reload();
        },
        error: function (data) {
            console.log('Error:', data);    
            var errors = data.responseJSON.errors;
            var firstItem = Object.keys(errors)[0];
            var firstItemErrorMsg = errors[firstItem][0];
            //Set Error Messages:
            $('#form-errors').html('<strong>Attention!!!</strong> ' + firstItemErrorMsg);
            $('#form-errors').show();
            //Change button text.
            $('#saveBtn').html('Save');
            $('#shipping-address').attr("disabled", "disabled");
        }
    }) // Ajax call
    /*
    * Store/Update function.
    * Save button click function:
    */
    $('#saveBtn').click(function(e){
       e.preventDefault();
       $(this).html('Sending..');
       var actionType = $(this).val();
       var mehtod;
       var action;
       if (actionType == 'store'){
           method = 'POST';
           action = '{{ route("invoices.store") }}';
       }
       if (actionType == 'update'){
           method = 'PATCH';
           action = '{{ route("invoices.index") }}' + '/' + $('#id').val();
       }
       //Ajax call to save data:
       $.ajax({
       data: $('#invoiceForm').serialize(),
                url: action,
                type: method,
                dataType: 'json',
                success: function (data) {
                    console.log('Success:', data);
                    $('#form-errors').hide();
                    $('#invoiceForm').trigger("reset");
                    $('#items .set').remove();
                    $('#saveBtn').html('Save');
                    $('#shipping-address').attr("disabled", "disabled");
                    //history.go(-1);
                    window.history.back();
                    location.reload(); 
                },
                error: function (data) {
                    console.log('Error:', data);    
                    var errors = data.responseJSON.errors;
                    var firstItem = Object.keys(errors)[0];
                    var firstItemErrorMsg = errors[firstItem][0];
                    //Set Error Messages:
                    $('#form-errors').html('<strong>Attention!!!</strong> ' + firstItemErrorMsg);
                    $('#form-errors').show();
                    //Change button text.
                    $('#saveBtn').html('Save');
                    $('#shipping-address').attr("disabled", "disabled");
                    //scroll top
                    //$(window).scrollTop(0);
                    //$('#orderForm').scrollTop(0);
                    $("html, body").animate({ scrollTop: 0 }, 1000);
                }
       }) // Ajax call

   })
   
   /*
   * Close Button Click function
    */
    $('#closeBtn').click(function(e){
        e.preventDefault();
        //parent.history.back();
        //location.reload(true);
        var sales = {{ config('constants.order_type.sales') }};
        var sample = {{ config('constants.order_type.sample') }};
        if( $('#order_type').val() == sales ) {
            var route = '{{ route("orders.index") }}' + '/' + $('#order_id').val();
        }
        if( $('#order_type').val() == sample) {
            var route = '{{ route("samples.index") }}' + '/' + $('#order_id').val();
        }
        window.location.href=route;
        //console.log(route);
        return false;
    })

}); //Document ready function.
    
</script>

@stop