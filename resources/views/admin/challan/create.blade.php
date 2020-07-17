<!-- 
    Author:     Alvah Amit Halder
    Document:   Delivery Challan create blade.
    Model/Data: App\Challan
    Controller: ChallanssController
-->

@extends('theme.default')

@section('title', __('VSF-Challan'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Create Delivery Challan'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dash') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">New Challan</li>
</ol>

<div class="container">
    <form name="challanForm" id="challanForm" method="POST" action="{{route('challans.store')}}" accept-charset="UTF-8">
        <div id="form-errors" class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert">×</button>
        </div>
        @csrf
        <!--hidden id input-->
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="q_type" id="q_type" value="{{ $order->quantity_type }}">
        <input type="hidden" name="customer_id" id="customer_id" value="{{ $order->user_id }}">
        <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">
        <div class="form-row col-md-12">
            <div class="form-group col-md-3">
                <label for="challan_date">Challan Date</label>
                <input type="date" name="challan_date" id="challan_date" class="form-control">
            </div>
            <div class="form-group col-md-3">
                <label for="challan_no">Challan No.</label>
                <input type="text" name="challan_no" id="challan_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
                <label for="order_no">Order No.</label>
                <input type="text" name="order_no" id="order_no" class="form-control" readonly="readonly" value="">
            </div>
            <div class="form-group col-md-3">
                <label for="challan_type">Challan Type</label>
                <select class="custom-select" name="challan_type" id="challan_type">
                    <!--<option value="0" selected>Choose...</option>-->
                    <option value="1">Delivery Challan</option>
                    <!--<option value="2">Transfer Challan</option>-->
                </select>
            </div>
        </div>
        <div id="add-for-delivery-challan" class="form-row col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="supplied_by">Supplied By:</label>
                    <textarea rows = "4" class="form-control" name = "supplied_by" id = "supplied_by" readonly="readonly" disabled="disabled"></textarea>
                </div>
                <div class="form-group">
                    <!--<label for="supply_store">Supply store:</label>-->
                    <select class="custom-select" name="supply_store" id="supply_store">
                        <option value="0" selected>Choose supply store...</option>
                        @foreach($stores as $store)
                        <option value="{{ $store->id }}"> {{ $store->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="delivery_to">Delivery To:</label> 
                    <textarea rows="4" class="form-control" name="delivery_to" id="delivery_to" readonly="readonly" disabled="disabled"></textarea>
                </div>
                <div class="form-group">
                    <button id="choose-another-add" class="btn btn-primary btn-sm "><i class="fas fa-address-card"></i> Change</button>
                    <button id="edit-delivery-add" class="btn btn-secondary btn-circle btn-sm "><i class="fas fa-edit"></i> </button>
                </div>
            </div>
        </div>
        <!--Need to write a validation -->
        <!--<div class="form-row col-md-12">
            <div class="col-md-6">
                 <div class="form-group">
                     <div class="alert alert-warning p-3">
                         Warning!!!! Please check for sufficient stock before selecting store.<br>
                         Validation codes are not written yet.
                     </div>
                </div>
            </div>
        </div>-->
        <!--Code is written on 6th July 2020-->
        <!--delete after validation write-->


        <div class="form-row col-md-12 pt-2">
            <h5>Delivery Challan Details: <span id="qty_type"></span></h5>
            
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
                    </tbody>
                </table>
            </div> <!-- ./table-responsive -->
        </div> <!-- ./form-row -->
        <div class="form-row col-md-12 pt-2">
            <div class="form-group col-md-3 offset-md-3">
                <button type="submit" class="btn btn-success form-control" id="saveBtn" value="store">Save</button>
            </div>
            <div class="form-group col-md-3">
                <button class="btn btn-danger form-control" id="closeBtn">Close</button>
            </div>
        </div>
    </form> 
</div> <!-- ./container -->

<!--For Modal-->
<div class="modal fade" id="ajaxModel" role="dialog" aria-labelledby="..." aria-hidden="true">
    <div class="modal-dialog my-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> <!-- ./modal-header -->
            <div class="modal-body my-modal-body">
                <div class="container-fluid">
                    <div id="displayEmail" class="container-fluid"></div>
                    <div id="displayContact" class="container-fluid pb-3"></div>
                    <!-- Bootstrap4 Carousel -->
                    <div id="carouselIndicators" class="carousel slide">
                        <ol class="carousel-indicators"></ol> <!-- Content added by jQuery -->
                        <div id="carouselInner" class="carousel-inner"></div> <!-- Content added by jQuery -->
                        <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div> <!-- ./carousel -->
                </div> <!-- ./container-fluid -->
            </div> <!-- ./modal-body -->
        </div> <!-- ./modal-content -->
    </div> <!-- ./modal-dialog -->
</div> <!-- #/ajaxModel -->

<style>
    .my-modal-dialog { 
        max-width: 40%; 
        width: 40% !important; 
    }
    .my-modal-body{
        background-color: lightgray;
    }
    .carousel-item{
        text-align: left;
        padding-left: 55px;
        padding-right: 55px;
    }
    .carousel-indicators {
        bottom:-50px;
    }
    .carousel-inner {
        margin-bottom:20px;
    }
    label{
            margin-bottom: 0;
            padding-bottom: 0;
        }
    @media (max-width: 575px) {
        .my-modal-dialog {
            max-width: 95%; 
            width: 95% !important;
        }
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
<!--Script for this page-->
<script type="text/javascript">
$(document).ready(function(){
    
    $('input').addClass('form-control-sm');
    $('select').addClass('custom-select-sm');
    
    
    /*
     * Disable choose-another-add button
     * if customer_id is empty.
     */
    if( !($('#customer_id').val()) ){
        $('#choose-another-add').attr('disabled', 'disabled');
    }

    /*
    * Get Order data to fill challan.
    */
    var order_id = $('#order_id').val();
    var mehtod = 'GET';
    var action = '{{ route("get.order.for.challan") }}';
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
            $('#delivery_to').val(data.order.customer_name+'\n'+data.order.customer_company+'\n'+data.order.customer_address1+'\n'+data.order.customer_address2);
            $('#supplied_by').val('VSF Distribution\n7/1/A Lake Circus\nKolabagan, North Dhanmondi\nDhaka 1205');
            $(data.order.products).each(function(index, value){
                var row_count = $('#items tr').length - 1;
                var row_no = + row_count + 1;
                var trID = 'set' + row_no; //This is the table row ID for new row.
                var html = '<tr id="' + trID + '" class="set">' +
                        '<td><input type="text" name="item_name[]" id="item_name' + row_no + '" class="form-control form-control-sm" readonly="readonly" value="'+ value.name +'"></td>' +
                        '<input type="hidden" name="item_id[]" id="item_id' + row_no + '" value="'+ value.id +'">' +
                        '<td class="text-center"><input type="text" name="item_unit[]" id="item_unit' + row_no + '" class="form-control form-control-sm" value="'+ value.pivot.product_packing +'" readonly="readonly"></td>'+
                        '<td class="text-center"><input type="number" name="item_qty[]" id="item_qty' + row_no + '" class="form-control form-control-sm text-center item_qty" value="'+ value.pivot.quantity +'"></td>'+
                        '<input type="hidden" name="invoicable_qty[]" id="invoicable_qty' + row_no + '" value="'+ value.pivot.quantity +'">' +
                        '<td><button id="remove' + row_no + '" type="button" class="close" data-dismiss="alert" >&times;</button></td>' +
                        '</tr>';
                $('#items tbody').append(html);
            });
            
           /*
           * Removing Dynamic Rows 
           */
           $('.close').click(function(e){
               e.preventDefault();
               var el_id = event.target.id;
               var row_no = el_id.substr(6, );
               var trID = 'set' + row_no;
               $('#' + trID).remove();
           });
            
            $('#form-errors').hide();
            //$('#challanForm').trigger("reset");
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
    
    
    /*
    * Edit delivery address button click action 
    */
    $('#edit-delivery-add').click(function(e){
        e.preventDefault();
        var disabled = $('#delivery_to').prop('disabled');
        if (disabled) {
            $("#delivery_to").prop('disabled', false);		// if disabled, enable
            $('#delivery_to').prop('readonly', false);
        } else {
          $("#delivery_to").prop('disabled', true);		// if enabled, disable
          $('#delivery_to').prop('readonly', true);
        }
    });
    
    /*
     * Clear customer details view area:
     */
    function clearViewFields(){
        $('#modelHeading').html('');
        $('#carouselIndicators ol li').remove();
        $('#carouselInner div').remove(); 
        $('#displayEmail').html(''); 
        $('#displayContact').html(''); 
    }
    
    /*
     * Clear adddress fields function:
     */
    function clearAddressFields(){
        $('#address_id').val('');
        $('#address_label').val('').attr('selected','selected');
        $('#is_primary').removeAttr('checked');
        $('#is_billing').removeAttr('checked');
        $('#is_shipping').removeAttr('checked');
        $('#organization').val('');
        $('#address').val('');
        $('#state').val('');
        $('#city').val('');
        $('#postal_code').val('');
        $('#area').val('');
        $('#latitude').val('');
        $('#longitude').val('');
        $('#country_code').val('').attr('selected','selected');
    }
    
    /*
     * ajaxModel hidden jQuery:
     * Clear all fields and reset form upon hide. 
     */
    $('#ajaxModel').on('hidden.bs.modal', function (e) {
        clearViewFields();
        clearAddressFields();
    });
    
    /*
    * Choose another button click action
    */
    $('#choose-another-add').click(function(e){
        e.preventDefault();
        var customerId = $('#customer_id').val();
        $.get('{{ route("customers.index") }}' +'/' + customerId, function (data) {
            var name = data['customer']['name'];
            var addresses = data['customer']['addresses'];
            var contacts = data['customer']['contacts'];
            var contactList;
            $('#modelHeading').html(name);
            $('#displayEmail').html( 
                        '<div class="container">'+
                            '<span><i class="far fa-envelope"></i> '+
                            data['customer']['email']+'</span> '+ 
                            ' <span><i class="fas fa-tag"></i> '+
                            data['customer']['role'][0]['name']+
                            '</span>'+
                        '</div>'
                    ).show();
            
            if(contacts.length>0){
                $('#displayContact').html('<div class="container"></div>');
                $(contacts).each(function(index, value){
                    var country_code;
                    var city_code;
                    value.country_code != null ? country_code = value.country_code : country_code = '';
                    value.city_code != null ? city_code = value.city_code : city_code = '';
                    $('#displayContact .container').append( 
                        '<span><i class="fas fa-phone"></i> '+
                        country_code+'-'+city_code+'-'+value.number+ 
                        '</span> '+ 
                        '<span><i class="fas fa-tag"></i> '+value.label+'</span><br>' 
                    ); 
                });
            } else {
                $('#displayContact').html('No contacts added yet.');
            }
            
            if(addresses.length > 0){
                $(addresses).each(function(index, value){
                    var is_primary; 
                    var is_billing; 
                    var is_shipping;
                    var contact =[];
                    if(value.pivot.is_primary) { 
                        is_primary = '<input class="form-check-input" type="checkbox" checked="checked">';
                    } else { is_primary = '<input class="form-check-input" type="checkbox">'; }
                    if(value.pivot.is_billing) { 
                        is_billing = '<input class="form-check-input" type="checkbox" checked="checked">';
                    } else { is_billing = '<input class="form-check-input" type="checkbox">'; }
                    if(value.pivot.is_shipping) { 
                        is_shipping = '<input class="form-check-input" type="checkbox" checked="checked">';
                    } else { is_shipping = '<input class="form-check-input" type="checkbox">'; } 
                    
                    //Set up contacts html:
                    var list = '<ul>';
                    $(contact).each( function(index, value){list += '<li>'+value+'</li>' ; });
                    list += '</ul>';
                    //conlose.log(list);
                    $('#carouselIndicators ol').append('<li data-target="#carouselIndicators" data-slide-to="'+index+'"></li>');
                    $('#carouselInner').append(
                        '<div class="carousel-item">'
                        +'<span class="float-left">Address type: <strong>'+value.label+'</strong></span><br>'
                        +'<div class="form-check form-check-inline">'
                        +is_primary
                        +'<label class="form-check-label">Primary</label>'
                        +'</div>'
                        +'<div class="form-check form-check-inline">'
                        +is_billing
                        +'<label class="form-check-label">Billing</label>'
                        +'</div>'
                        +'<div class="form-check form-check-inline">'
                        +is_shipping
                        +'<label class="form-check-label">Shipping</label>'
                        +'</div>'
                        +'<p><strong>'+value.organization+'</strong><br>\r\n'
                        +value.address+'<br>\r\n'
                        +value.state+', '
                        +value.city+'<br>\r\n'
                        +value.postal_code+'</p>'
                        +'<button class="useBtn btn btn-primary right float-right" >Use</button>'
                        +'</div>'
                    );
                    //console.log(value.pivot.is_primary);
                });
            } else {
                $('#carouselInner').append(
                    '<div class="carousel-item">'
                    +'<p>No addresses found for this user.</p>'
                    +'</div>'
                );
            }
            //Set active classes for carousal to function properly:
            $('#carouselIndicators ol li').each(function(){
                $(this).attr('data-slide-to') == '0' ? $(this).attr('class','active') : '' ;
            });
            $('#carouselInner div').first().addClass('active');
            //Finally show modal:
            $('#carouselIndicators').show();
            $('#ajaxModel').modal('show');
            
            
            $('button.useBtn').click(function(){
                var add = $(this).prev().text();
                var phones = $('#displayContact .container').text();
                $('#delivery_to').val(name+' \r\n'+add+' \r\n'+phones);
                $('#delivery_to').attr('disabled', 'disabled');
                $('#ajaxModel').modal('hide');
            });
            
        });
        //Stop following the link address:
        return false;
    });
    
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
           action = '{{ route("challans.store") }}';
       }
       if (actionType === 'update'){
           method = 'PATCH';
           action = '{{ route("challans.index") }}' + '/' + $('#id').val();
       }
       $('#delivery_to').removeAttr('disabled');
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
                   $('#delivery_to').attr('disabled', 'disabled');
                   $('#closeBtn').trigger('click');
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
                   $('#delivery_to').attr('disabled', 'disabled');
                   $("html, body").animate({ scrollTop: 0 }, 1000);
                }
        }); // Ajax call

    });
    
    
    $('#closeBtn').click(function(e){
        e.preventDefault();
        var route = '{{ route("orders.index") }}' + '/' + $('#order_id').val();
        window.location.href=route;
        return false;
    });
    
    /*
    * System notification:
     */
//    $('#supply_store').click(function(){
//        bootbox.alert({
//            title: "<span class='text-danger font-weight-bold'>Warning!!! System has limitations:</span>",
//            message: "<span class='text-danger'>Please check for sufficient stock before selecting store.<br>Validation codes are not written yet.</span>",
//            backdrop: true,
//            centerVertical: true,
//            //className: 'bg-danger',
//            //className: 'rubberBand animated',
//            //size: 'lg',
//            animate: true,
//            buttons: {
//                ok: {
//                    label: 'I understand !!!',
//                    className: 'btn-sm btn-danger'
//                }
//            }
//        });
//    });
    
}); //Document ready function.
</script>

@stop