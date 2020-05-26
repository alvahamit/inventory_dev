<!-- 
    Author:     Alvah Amit Halder
    Document:   Stock Transfer blade.
    Model/Data: App\Challan
    Controller: ChallanController
-->

@extends('theme.default')

@section('title', __('VSF-Stock Transfer'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Transfer Challan'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dash') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Transfer Challan</li>
</ol>

<div class="container">
    <form name="challanForm" id="challanForm" method="POST" action="{{route('challans.store')}}" accept-charset="UTF-8">
        <div id="form-errors" class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert">×</button>
        </div>
        @csrf
        <!--hidden id input-->
        <input type="hidden" name="id" id="id">
        <div class="form-row col-md-12">
            <div class="form-group col-md-4">
                <label for="challan_date">Challan Date</label>
                <input type="date" name="challan_date" id="challan_date" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label for="challan_no">Challan No.</label>
                <input type="text" name="challan_no" id="challan_no" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label for="challan_type">Challan Type</label>
                <select class="custom-select" name="challan_type" id="challan_type">
                    <option value="2">Transfer Challan</option>
                </select>
            </div>
        </div>
        <div id="add-for-transfer-challan" class="form-row col-md-12">
            <div class="form-group col-md-6">
                <label for="from_store">Move from:</label>
                <select class="custom-select" name="from_store" id="from_store">
                    <option value="0" selected>Choose...</option>
                    @foreach($stores as $store)
                    <option value="{{ $store->id }}"> {{ $store->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="to_store">To store:</label>
                <select class="custom-select" name="to_store" id="to_store">
                    <option value="0" selected>Choose...</option>
                    @foreach($stores as $store)
                    <option value="{{ $store->id }}"> {{ $store->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row col-md-12 pt-2">
            <h5>Transfer Challan Details: <span id="qty_type"></span></h5>
            
            <div class="table-responsive">
                <table class="table table-sm" id="items">
                    <thead>
                        <tr>
                            <th class="" style="width: 35%">Item Name</th>
                            <th class="text-center" style="width: 40%">Packing</th>
                            <th class="text-center" style="width: 25%">Quantity</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
<!--                        <tr>
                            <td><input type="text" name="item_name[]" id="item_name" class="form-control" readonly="readonly"></td>
                            <td class="text-center"><input type="text" name="item_unit[]" id="item_unit" class="form-control" readonly="readonly"></td>
                            <td class="text-center"><input type="text" name="item_qty[]" id="item_qty" class="form-control" readonly="readonly"></td>
                            <td><button id="remove" type="button" class="close" data-dismiss="alert">&times;</button></td>
                        </tr>-->
                    </tbody>
                </table>
            </div> <!-- ./table-responsive -->
        </div> <!-- ./form-row -->
        <div class="form-row col-md-12 pt-2">
            <div class="form-group col-md-6">
                <button type="submit" class="btn btn-success form-control" id="saveBtn" value="store">Save</button>
            </div>
<!--            <div class="form-group col-md-4">
                <button class="btn btn-danger form-control" id="deleteBtn">Delete</button>
            </div>-->
            <div class="form-group col-md-6">
                <button class="btn btn-danger form-control" id="closeBtn">Close</button>

            </div>
        </div>
    </form> 
</div> <!-- ./container -->
@stop

@section('scripts')
<!--Script for this page--> 
<script type="text/javascript">
$(document).ready(function(){
    $('#form-errors').hide();
    /*
    * Get Stock data to fill form.
    * Disable selected from "To Store"
    */
    $('#from_store').change(function(){
        var id = $(this).val();
        $('#to_store option:disabled').removeAttr('disabled');
        $('#to_store option[value='+id+']').attr('disabled','disabled');
        $('#to_store').prop('selectedIndex',0);
        //Fill up form 
        $('#items tbody').html('');
        var mehtod = 'GET';
        var action = '{{ route("get.store.stock") }}';
        $.ajax({
            data: {'id': id},
            url: action,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log('Success:', data);
                var qt = 'packing';
                $('#qty_type').html('(Qty. by '+qt+')');
                $(data.store).each(function(index, value){
                    var row_count = $('#items tr').length - 1;
                    var row_no = + row_count + 1;
                    var trID = 'set' + row_no; //This is the table row ID for new row.
                    var html = '<tr id="' + trID + '" class="set">' +
                            '<td><input type="text" name="item_name[]" id="item_name' + row_no + '" class="form-control" readonly="readonly" value="'+ value.name +'"></td>' +
                            '<input type="hidden" name="item_id[]" id="item_id' + row_no + '" value="'+ value.product_id +'">' +
                            '<td class="text-center"><input type="text" name="item_unit[]" id="item_unit' + row_no + '" class="form-control" value="'+ value.packing +'" readonly="readonly"></td>'+
                            '<td class="text-center"><input type="number" name="item_qty[]" id="item_qty' + row_no + '" class="form-control text-center item_qty" value="'+ value.quantity +'"></td>'+
                            '<input type="hidden" name="invoicable_qty[]" id="invoicable_qty' + row_no + '" value="'+ value.quantity +'">' +
                            '<td><button id="remove' + row_no + '" type="button" class="close" data-dismiss="alert" >&times;</button></td>' +
                            '</tr>';
                    $('#items tbody').append(html);

                });
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
                });
                $('#form-errors').hide();
                $('#saveBtn').html('Save');
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
            }
        }); // Ajax call
    }) 
    
    
    /*
    * Store/Update function.
    * Save button click function:
    */
    $('#saveBtn').click(function(e){
       e.preventDefault();
       $(this).html('Sending..');
       $('#form-errors').hide();
       var actionType = $(this).val();
       var mehtod;
       var action;
       if (actionType === 'store'){
           method = 'POST';
           action = '{{ route("challans.store.transfer") }}';
       }
       if (actionType === 'update'){
           method = 'PATCH';
           action = '{{ route("challans.index") }}' + '/' + $('#id').val();
       }

       //Ajax call to save data:
       $.ajax({
       data: $('#challanForm').serialize(),
               url: action,
               type: method,
               dataType: 'json',
               success: function (data) {
                   console.log('Success:', data);
                   $('#form-errors').hide();
                   $('#challanForm').trigger("reset");
                   $('#items .set').remove();
                   $('#saveBtn').html('Save');
                   //history.go(-1);
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
               }
       }); // Ajax call

   });
    
    
    $('#closeBtn').click(function(e){
        e.preventDefault();
        history.go(-1);
    });

}); //Document ready function.
</script>
@stop