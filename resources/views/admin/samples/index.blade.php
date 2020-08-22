<!-- 
    Author:     Alvah Amit Halder
    Document:   Sample Orders's Index blade.
    Model/Data: App\Order
    Controller: SamplesController
-->

@extends('theme.default')

@section('title', __('VSF- Samples'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Sampling Requests:'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')


<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">Samples</li>
</ol>

<!--<h1>Hi!! you have following orders:</h1>-->
<!--Add new button-->
<div class="form-group text-right d-print-none">
    <button id="createNew" class="btn btn-primary right">Add New</button>
</div> 
<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Samples Data Table </div>
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
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>

<!--For Modal-->
<div class="modal mymodal fade bd-example-modal-lg" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog mymodal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mymodal-body">
                
                <!--Order Form-->
                <form id="orderForm" name="orderForm" class="form-horizontal" autocomplete="off">
                    <div id="form-errors" class="alert alert-warning"></div>
                    @csrf
                    <!--hidden id input-->
                    <input type="hidden" name="id" id="id">
                    
                    <!-- form-group -->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-3">
                                <label for="order_no">Ref. Number:</label>
                                <input type="text" name="order_no" id="order_no" class="form-control" autofocus="autofocus" value="{{old('order_no')}}">
                            </div>
                            <div class="col-md-3 offset-md-6">
                                <label for="order_date">Date:</label>
                                <input type="date" name="order_date" id="order_date" class="form-control" value="{{old('order_date')}}">
                            </div>
                        </div>
                    </div>
                    <!-- ./form-group -->
                    
                    <!--Accordion-->
                    <div class="accordion pb-3" id="accordionExample">
                        <!--Card of General Information-->
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Sample Addresses:
                                    </button>
                                </h2>
                            </div> <!--#/headingOne--> 
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="container">
                                        <!-- form-group -->
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modelHeading">Invoice Address</h5>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="pt-1">
                                                            <div class="checkbox">
                                                                <label><input id="select-customer" name="select-customer" type="checkbox" value="1"> Select customer form list</label>
                                                            </div>
                                                        </div>
                                                        
                                                        <fieldset id="select-customer-fieldset" style="display: none" disabled="disabled"> <!-- select-customer-fieldset -->
                                                            <label for="user_id">Customer's Name:</label>
                                                            <select name="user_id" id="user_id" class="custom-select">
                                                                <option value="">Select customer...</option>
                                                            </select>
                                                            <div class="pt-1">
                                                                <label for="select_customer_company">Company:</label>
                                                                <input type="text" name="select_customer_company" id="select_customer_company" 
                                                                       class="form-control" value="{{old('select_customer_company')}}">
                                                            </div>
                                                            <div class="pt-1">
                                                                <label for="select_customer_address">Address:</label>
                                                                <textarea type="text" name="select_customer_address" id="select_customer_address" 
                                                                          class="form-control" rows="3">{!! old('select_customer_address') !!}</textarea>
                                                            </div>
                                                            <div class="pt-1">
                                                                <label for="select_customer_contact">Contact no:</label>
                                                                <input type="text" name="select_customer_contact" id="select_customer_contact" 
                                                                       class="form-control" value="{{old('select_customer_contact')}}">
                                                            </div>
                                                        </fieldset> <!-- #/select-customer-fieldset -->
                                                        
                                                        <fieldset id="new-customer-fieldset"> <!-- #new-customer-fieldset -->
                                                            <div class="pt-1">
                                                                <label for="customer_name">Customer Name:</label>
                                                                <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{old('customer_name')}}">
                                                            </div>
                                                            <div class="pt-1">
                                                                <label for="customer_company">Company:</label>
                                                                <input type="text" name="customer_company" id="customer_company" class="form-control" value="{{old('customer_company')}}">
                                                            </div>
                                                            <div class="pt-1">
                                                                <label for="customer_address">Address:</label>
                                                                <textarea type="text" name="customer_address" id="customer_address" class="form-control" 
                                                                          rows="3">{!! old('customer_address') !!}</textarea>
                                                            </div>
                                                            <div class="pt-1">
                                                                <label for="contact_no">Contact no:</label>
                                                                <input type="tel" name="contact_no" id="contact_no" class="form-control" value="{{old('contact_no')}}">
                                                            </div>
                                                        </fieldset> <!-- #/new-customer-fieldset -->
                                                        
                                                    </div> <!-- ./form-group -->
                                                </div> <!-- ./col-md-6 -->
                                                <div class="col-md-6">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modelHeading">Shipping Address</h5>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="pt-1">
                                                            <div class="checkbox">
                                                                <label><input id="same_address" name="same_address" type="checkbox" value="1" checked="true"> Same as billing</label>
                                                            </div>
                                                        </div>
                                                        
                                                        <fieldset id="shipping-address" disabled="true"> <!--#shipping-address fieldset-->
                                                            <div class="pt-1">
                                                                <label for="customer_name_shipping">Receiver's Name:</label>
                                                                <input type="text" name="customer_name_shipping" id="customer_name_shipping" 
                                                                       class="form-control" value="{{old('customer_name_shipping')}}">
                                                            </div>
                                                            <div class="pt-1">
                                                                <label for="shipping_company">Company:</label>
                                                                <input type="text" name="shipping_company" id="shipping_company" 
                                                                       class="form-control" value="{{old('shipping_company')}}">
                                                            </div>
                                                            <div class="pt-1">
                                                                <label for="shipping_address">Address:</label>
                                                                <textarea type="text" name="shipping_address" id="shipping_address" class="form-control" 
                                                                          rows="3"value="">{!! old('shipping_address') !!}</textarea>
                                                            </div>
                                                            <div class="pt-1">
                                                                <label for="shipping_address2">Contact no:</label>
                                                                <input type="tel" name="shipping_contact" id="shipping_contact" 
                                                                       class="form-control" value="{{old('shipping_contact')}}">
                                                            </div>
                                                        </fieldset> <!--#/shipping-address fieldset-->
                                                        
                                                    </div> <!--./form-group-->
                                                </div> <!-- ./col-md-6 -->
                                            </div> <!-- ./form-row -->
                                        </div> <!-- ./form-group -->
                                    </div> <!--./container-->                    
                                </div> <!--./card-body-->
                            </div> <!--#/collapseOne-->
                        </div> <!--./card--> 
                        <!--Card of Order Items-->
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        Sample Items:
                                    </button>
                                </h2>
                            </div> <!--#/headingTwo--> 
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="form-group"> <!-- form-group -->
                                        <!--Unit chooser-->
                                        <div class="form-row pb-3">
                                            <label class="col-form-label col-form-label-sm" for="quantity_type">Quantity Type: </label>
                                            <select id="quantity_type" name="quantity_type" class="custom-select custom-select-sm col-md-3">
                                                <option value="">Wholesale Packing</option>
                                                <option value="pcs">Retail Unit/Pcs</option>
                                                <option value="weight">Weight/Volume</option>
                                            </select>
                                        </div>
                                        <div class="form-row">
                                            <div class="table-responsive">
                                                <table class="table" id="items">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 40%">Item &amp; Desc.</th>
                                                            <th style="width: 10%">Quantity</th>
                                                            <th style="width: 20%">Rate</th>
                                                            <th>Item Total</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr id="summery" style="display: none">
                                                            <td class="emptyrow"></td>
                                                            <td class="emptyrow"></td>
                                                            <td class="emptyrow text-xs-center"><strong>Total</strong></td>
                                                            <td class="emptyrow text-xs-right">
                                                                <input type="number" min="0" id="total" name="total" class="form-control form-control-sm"> 
                                                            </td>
                                                            <td class="emptyrow"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div> <!-- ./table-responsive -->
                                            <button name="add-row" id="add-row" class="btn btn-sm btn-success float-left"><i class="fas fa-plus"></i> Add Row</button>
                                        </div> <!-- ./form-row -->
                                    </div> <!-- ./form-group -->
                                    
                                </div> <!--./card-body-->
                            </div> <!--#/collapseTwo--> 
                        </div> <!--./card--> 
                    </div> <!-- /#accordionExample -->
                    <!--End of Accordion-->
                    <!--Form buttons-->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4 offset-md-2">
                                <button name="saveBtn" id="saveBtn" type="submit" class="btn btn-primary form-control" value="create-order">Save</button>
                            </div>
                            <div class="col-md-4">
                                <button name="closeBtn" id="closeBtn" class="btn btn-danger form-control">Close</button>
                            </div>
                        </div>
                    </div>
                    <!--End Form buttons-->
                </form> <!--End Form -->
            </div> <!-- ./modal-body -->
        </div> <!-- ./modal-content -->
    </div> <!-- ./modal-dialog -->
</div>
<!--End of Modal-->


<style>
    .mymodal-dialog { 
        max-width: 70%; 
        width: 70% !important; 
        /*display: inline-block;*/ 
    }
    .mymodal{
        /*text-align: center;*/
    }
    .mymodal-body{
        background-color: lightgray;
    }
    @media (max-width: 575px) {
        .mymodal-dialog {
            max-width: 95%; 
            width: 95% !important;
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
 * To decode encoded as text html back to html.
 * @param {type} data
 * @returns {.document@call;createElement.value|txt.value}
 */
function htmlDecode(data){
    var txt = document.createElement('textarea');
    txt.innerHTML = data;
    return txt.value;
}

function fillBillingAddress(customer_name = '', organization = '', address = '', phone = ''){
    $('#select_customer_company').val(organization);
    $('#select_customer_address').val(address);
    $('#select_customer_contact').val(phone);
}

function fillShippingAddress(){
    if ($('#same_address').is(':checked')){
        if ($('#select-customer').is(':checked')){
            $('#customer_name_shipping').val($('#user_id option:selected').text());
            $('#shipping_company').val($('#select_customer_company').val());
            $('#shipping_address').val($('#select_customer_address').val());
            $('#shipping_contact').val($('#select_customer_contact').val());
        } else {
            $('#customer_name_shipping').val($('#customer_name').val());
            $('#shipping_company').val($('#customer_company').val());
            $('#shipping_address').val($('#customer_address').val());
            $('#shipping_contact').val($('#contact_no').val());
        }
    } else {
        clearShippingFields();
    }
}

function clearShippingFields(){
    $('#customer_name_shipping').val('');
    $('#shipping_company').val('');
    $('#shipping_address').val('');
    $('#shipping_contact').val('');
}

/*
 * This creates options for product selection: 
 * @param {int} id
 * @param {text} name
 * @param {Number} price
 * @param {text} packing
 * @returns {String}
 */
function addOption(id, name, price, stock){
    return '<option value="' + id + '">' + name + ' (Tk.' + price + '), Available: ' + stock + '</option>';
}

/*
 * This calculates item subtotal.
 * @param {Number} row_no
 * @returns {Number}
 */
function subTotal(row_no){
    return $('#qty' + row_no).prop('value') * $('#unit_price' + row_no).prop('value');
}

/*
 * Reset Modal:
 * Close (modal) function:
 */
function closeModal(){
    $('#form-errors').hide();
    $('#saveBtn').html('Save');
    $('#orderForm').trigger("reset");
    $('#items .set').remove();
    $('#id').val('');
    $('#select-customer').removeAttr('checked');
    $('#same_address').attr('checked','checked');
    $('#shipping-address').attr('disabled',true);
    $('#ajaxModel').modal('hide');
} 

/*
 * @param {boolean} status
 * @param {string} message
 * @returns {String}
 * Description: This function is used to show page message.
 */
function showMsg(status, message)
{
    if(status == false)
    {
        var html =  '<div class="alert alert-warning alert-dismissible fade show">'+
                        '<strong>'+ message + '</strong>'+
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                    '</div>'
        return html;
    }
    if(status == true)
    {
        var html =  '<div class="alert alert-success alert-dismissible fade show">'+
                        '<strong>'+ message + '</strong>'+
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                    '</div>'
        return html;
    }
}


$(document).ready(function(){
    /*
     * Initialize Yajra on document table.
     */
    $('#dataTable').DataTable({
    processing: true,
            servirSide: true,
            ajax: {
            url: "{{ route('samples.index') }}",
            },
            columns: [
            {data: 'id', name: 'id'},
            {data: 'order_no',
                    name: 'order_no',
                    render: function(data){return htmlDecode(data); }
            },
            {data: 'order_date', name: 'order_date'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'quantity_type', name: 'quantity_type'},
            {data: 'order_total', name: 'order_total'},
            {data: 'is_invoiced', name: 'is_invoiced'},
            {data: 'order_status', name: 'order_status'},
            ],
            order:[[0, "desc"]],
    });
    /*
     * Initialize form with:
     */
    $('#add_customer').attr("checked", "true");
    getProductsByQuantityType();
    /*
     * Setting modal options dynamically:
     */
    $.get("{{ route('samples.create') }}", function (data) {
        //var ptype = data.purchase_type;
        var buyers = data.buyers;
        $.each(buyers, function(index, value) {
            $('#user_id').append($("<option></option>").attr('value', value['id']).text(value['name']));
        });
        //console.log(data);
    }); //Get function.

    /*
     * Create new order:
     * Show/View Modal Form.
     */
    $('#createNew').click(function () {
        $('#closeBtn').html("Close");
        $('#closeBtn').val("close-modal");
        $('#saveBtn').val("create-order");
        $('#id').val('');
        $('#form-errors').hide();
        $('#orderForm').trigger("reset");
        $('#modelHeading').html("Create New Sample Request");
        $.get("{{ route('get.sample.ref') }}", function (data) {
            $('#order_no').val(data);
        });
        //Setup modal option:
        $('#ajaxModel').modal({
            backdrop: 'static',
            keyboard: false,
            closeButton: true,
        });
        $('#closeBtn').show();
        $('#ajaxModel').modal('show');
        $('#ajaxModel').modal('handleUpdate');
        $('#add-row').trigger('click');
        $('#order_no').trigger('focus');
    }); //Create New - Click function.

    /*
     * When modal is hidden
     * Change 
     */
    $('#ajaxModel').on("hidden.bs.modal", function () {
        var fieldsetForNew = $('#new-customer-fieldset');
        var fieldsetForSelect = $('#select-customer-fieldset');
        fieldsetForNew.removeAttr('disabled');
        fieldsetForNew.show();
        fieldsetForSelect.attr('disabled', 'true');
        fieldsetForSelect.hide();
        closeModal();
    });


    /*
     * Billing checkbox funciton:
     */
    $('#select-customer').click(function () {
        var fieldsetForNew = $('#new-customer-fieldset');
        var fieldsetForSelect = $('#select-customer-fieldset');
        if ($(this).prop("checked") == true) {
            fieldsetForNew.attr('disabled', 'true');
            fieldsetForNew.hide();
            fieldsetForSelect.removeAttr('disabled');
            fieldsetForSelect.show();
            $('#add_customer').removeAttr("checked");
            fillShippingAddress();
        }
        if ($(this).prop("checked") == false) {
            fieldsetForNew.removeAttr('disabled');
            fieldsetForNew.show();
            fieldsetForSelect.attr('disabled', 'true');
            fieldsetForSelect.hide();
            $('#add_customer').attr("checked", "true");
            clearShippingFields();
        }
    });
    /*
     * Shipping checkbox function:
     */
    $('#same_address').click(function () {
        var fieldset = $('#shipping-address');
        $(this).prop("checked") == true ? fieldset.attr('disabled', 'true') : fieldset.removeAttr('disabled');
        fillShippingAddress();
    });
    $('#customer_name').keyup(function(){ fillShippingAddress(); })
    $('#customer_company').keyup(function(){ fillShippingAddress(); })
    $('#customer_address').keyup(function(){ fillShippingAddress(); })
    $('#contact_no').keyup(function(){ fillShippingAddress(); })
    /*
     * Customer select on change function:
     */
    $('#user_id').click(function(){
        var user_id = $(this).val();
        var customer_name = $('#user_id option:selected').text();
        var organization = '';
        var address = '';
        var phone = '';
        var action = '{{ route("ajax-order.getaddress") }}';
        var method = 'GET';
        $.ajax({
            data: { "id": user_id },
            url: action,
            type: method,
            dataType: 'json',
            success: function(data) {
                console.log('Success:', data); 
                organization = data['buyer']['organization'];

                var contactArray = [];
                $.each(data['contacts'], function(index, value){
                    var ph = data['contacts'][index]['country_code'] +'-' 
                            + data['contacts'][index]['city_code'] + '-' 
                            + data['contacts'][index]['number'];
                    contactArray.push(ph);
                });
                phone = contactArray.toString();

                var addressOptions = [];
                $.each(data['address'], function(index, value){
                    //if (data['address'][index]['pivot']['is_primary']){
                        //addressOptions.push({ 'text': data['address'][index]['address'], 'value': data['address'][index]['id'] });
                    //}
                    addressOptions.push({ 'text': data['address'][index]['address'], 'value': data['address'][index]['id'] });
                });
                if (addressOptions.length > 1){
                    bootbox.prompt({
                    title: "Address selector",
                            message: '<p>Please select an address to use from below:</p>',
                            inputType: 'radio',
                            inputOptions: addressOptions,
                            callback: function (result) {
                                //console.log(result);
                                $.each(data['address'], function(index, value){
                                    if (data['address'][index]['id'] == result){
                                        address = data['address'][index]['address'] + '\r\n' + data['address'][index]['city'] + ' ' + data['address'][index]['postal_code'];
                                        fillBillingAddress(customer_name, organization, address, phone);
                                        fillShippingAddress();
                                    }
                                });
                            }
                    });
                } 
                else 
                {
                    $.each(data['address'], function(index, value){
    //                            if (data['address'][index]['pivot']['is_primary'])
    //                            {
    //                                address = data['address'][index]['address'] + '\r\n' + data['address'][index]['city'] + ' ' + data['address'][index]['postal_code'];
    //                                fillBillingAddress(customer_name, organization, address, phone);
    //                                fillShippingAddress();
    //                            }
                        address = data['address'][index]['address'];
                        if(data['address'][index]['city'] !== null){ address += '\r\n' + data['address'][index]['city']; }
                        if(data['address'][index]['postal_code'] !== null){ address += ' '+data['address'][index]['postal_code']; }
                        fillBillingAddress(customer_name, organization, address, phone);
                        fillShippingAddress();

                    });
                }


            },
            error: function(data) { console.log('Error:', data); }
        });
    //console.log(user_id);
    });
    /*
     * Ajax Call goes to: PurchaseController@getProdData
     * This call gets product data for adding 
     * item rows.
     */
    var productOptions; //This value is set by ajax call. 
    function getProductsByQuantityType(quantity_type = ""){
        //var quantity_type = $('#quantity_type').val();
        $.ajax({
            url: "{{ route('ajax-order.get.product.options') }}",
            type: "GET",
            data:{  'quantity_type': quantity_type },
            cache: false,
            dataType: 'json',
            success: function(response){
                productOptions = response.items;
                },
            error: function(response){
                console.log(response);
                }
        });
    }

    $('#quantity_type').change(function(){
        var qty_type = $('#quantity_type').val();
        $('#items .set').remove();
        $('#total').val('');
        $("#summery").hide();
        getProductsByQuantityType(qty_type);
    });
    
        
    
    /*
     * Modal "Add Row" click function:
     * Adding Dynamic Rows
     */
    $("#add-row").click(function(e){
        e.preventDefault();
        $("#summery").show();
        var row_count = $('#items tr').length - 2;
        var row_no = + row_count + 1;
        var trID = 'set' + row_no; //This is the table row ID for new row.
        var options; //To store options for product choice.
        //Javascript to itarate through productOptions:
        productOptions.forEach(function(option){
            //console.log(option);
            options += addOption(option.id, option.name, option.price, option.stock);
        });
        // Storing HTML code block in a variable
        var html = '<tr id="' + trID + '" class="set">' +
                '<td>' +
                '<select name="product_ids[]" class="custom-select custom-select-sm">' +
                '<option value="">-- Choose product --</option>' +
                options +
                '</select>' +
                '</td>' +
                '<td><input type="number" min="0" id="qty' + row_no + '" name="quantities[]" class="form-control form-control-sm qty"/></td>' +
                '<td><input type="number" min="0" id="unit_price' + row_no + '" name="unit_prices[]" class="form-control form-control-sm unit_price"/></td>' +
                '<td><input type="number" min="0" id="item_total' + row_no + '"  name="item_totals[]" class="form-control form-control-sm item_total"/></td>' +
                '<td><button id="remove' + row_no + '" type="button" class="close" data-dismiss="alert">&times;</button></td>' +
                '</tr>';
        $('#summery').before(html);
        
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
            $('.item_total').trigger('change');
            $('#items tr').length > 2 ? $("#summery").show() : $('#total').prop('value', '') && $("#summery").hide();
            //console.log($('#items tr').length);
        });
        /*
         * Subtotal on change of:
         * quantity. 
         */
        $('.qty').keyup(function(e){
            e.preventDefault();
            var el_id = event.target.id;
            var row_no = el_id.substr(10, );
            $('#item_total' + row_no).prop('value', subTotal(row_no));
            $('.item_total').trigger('change');
        });
        /*
         * Subtotal on change of:
         * unit price. 
         */
        $('.unit_price').keyup(function(e){
            e.preventDefault();
            var el_id = event.target.id;
            var row_no = el_id.substr(10, );
            $('#item_total' + row_no).prop('value', subTotal(row_no));
            $('.item_total').trigger('change');
        });
        /*
         * Invoice Total
         */
        $('#items').find('.item_total').on('change', function(){
            var sum = 0;
            $('.item_total').each(function(){
            sum = + sum + + $(this).val();
            });
            $('#total').prop('value', sum);
        });
    
        
    }); //#add-row
    
    
    /*
     * Save button click function:
     */
    $('#saveBtn').click(function(e){
        e.preventDefault();
        $(this).html('Sending..');
        var actionType = $(this).val();
        var mehtod;
        var action;
        if (actionType == 'create-order'){
            method = 'POST';
            action = '{{ route("samples.store") }}';
        };
        if (actionType == 'update'){
            method = 'PATCH';
            action = '{{ route("samples.index") }}' + '/' + $('#id').val();
        };
        
        //console.log(actionType);
        //console.log(action);
        
        $('#shipping-address').removeAttr("disabled");
        //Ajax call to save data:
        $.ajax({
            data: $('#orderForm').serialize(),
            url: action,
            type: method,
            dataType: 'json',
            success: function (data) {
                console.log('Success:', data);
                if($('#select-customer').prop('checked')==false){ 
                    closeModal();
                    location.reload(true); 
                } else {
                    closeModal();
                    $('#dataTable').DataTable().ajax.reload();
                }
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
                //$(window).scrollTo(0);
                //$('#orderForm').scrollTop(0);
                $("#ajaxModel .modal-body").animate({ scrollTop: 0 }, 1000);
                //$('#order_no').trigger('focus');
            }
        }); // Ajax call
    });


    /*
    * Close button click event: 
    */
    $('#closeBtn').click(function(e){
        e.preventDefault();
        if($('#closeBtn').val() == "close-modal"){ 
            closeModal();
        }
        if($('#closeBtn').val() == "delete"){
            $(this).html('Deleting...'); 
            // Confirm box
            bootbox.dialog({
                backdrop: true,
                centerVertical: true,
                size: 'medium',
                closeButton: false,
                message: "Are you doing this by mistake? <br> If you confirm a record will be permantly deleted. Please confirm your action.",
                title: "Please confirm...",
                buttons: {
                  success: {
                    label: "Confirm",
                    className: "btn-danger",
                    callback: function() {
                        var id = $('#id').val();
                        var action = '{{ route("orders.index") }}/' + id;
                        var method = 'DELETE';
                        $.ajax({
                            data: $('#orderForm').serialize(),
                            url: action,
                            type: method,
                            dataType: 'json',
                            success: function (data) {
                                console.log('Success:', data);
                                $('#orderForm').trigger("reset");
                                $('#closeBtn').html('Delete');
                                $('#ajaxModel').modal('hide');
                                $('#dataTable').DataTable().ajax.reload();
                                //Page message:
                                $('#pageMsg').html(showMsg(data.status, data.message));
                            },
                            error: function (data) {
                                //Change button text.
                                $('#closeBtn').html('Delete');
                                console.log('Error:', data);
                            }
                        }); // Ajax call
                        console.log(action);
                    }
                  },
                  danger: {
                    label: "Cancel",
                    className: "btn-success",
                    callback: function() {
                        $('#orderForm').trigger("reset");
                        $('#closeBtn').html('Delete');
                        closeModal();
                    }
                  }
                }
            });
        }
    });

    /*
    * Datatable Edit icon click:
    * Editing Order.
    */
    $('#dataTable').on('click', 'a.text-warning.edit', function (e) {
        e.preventDefault();
        var id = $(this).attr('href');
        //console.log(id);
        var action = '{{ route("ajax.order.get") }}';
        var method = 'GET';
        $.ajax({
            data: { "id": id },
            url: action,
            type: method,
            dataType: 'json',
            success: function(data) { 
                console.log(data);
                $('#id').val(data.order.id);
                $('#order_no').val(data.order.order_no);
                $('#order_date').val(data.order.unformated_order_date);
                $('#user_id').val(data.order.user_id).attr('selected', 'selected');
                $('#select_customer_company').val(data.order.customer_company);
                $('#select_customer_address').val(data.order.customer_address);
                $('#select_customer_contact').val(data.order.customer_contact);
                $('#customer_name_shipping').val(data.order.shipp_to_name);
                $('#shipping_company').val(data.order.shipp_to_company);
                $('#shipping_address').val(data.order.shipping_address);
                $('#shipping_contact').val(data.order.shipping_contact);
                $('#quantity_type').val(data.order.quantity_type).attr('selected', 'selected').trigger('change');
                //Get ordered products:
                $.ajax({
                    url: "{{ route('ajax-order.get.product.options') }}",
                    type: "GET",
                    data:{  'quantity_type': data.order.quantity_type },
                    cache: false,
                    dataType: 'json',
                    success: function(response){
                        productOptions = response.items;
                        var options;
                        $(data.order.products).each(function(index, value){
                            //console.log(value.id);
                            var row_count = $('#items tr').length - 2;
                            var row_no = + row_count + 1;
                            var trID = 'set' + row_no; //This is the table row ID for new row.
                            //Javascript to itarate through productOptions:
                            productOptions.forEach(function(option){
                                if(value.id == option.id){
                                    options += '<option value="' + option.id + '" selected="selected">' + option.name + ' (Tk.' + option.price + '), Available: ' + option.stock + '</option>';
                                } else {
                                    options += '<option value="' + option.id + '">' + option.name + ' (Tk.' + option.price + '), Available: ' + option.stock + '</option>';
                                }
                            })
                            var html = '<tr id="' + trID + '" class="set">' +
                                '<td>' +
                                '<select name="product_ids[]" class="custom-select custom-select-sm">' +
                                '<option value="">-- Choose Product --</option>' +
                                options +
                                '</select>' +
                                '</td>' +
                                '<td><input type="number" min="0" id="qty' + row_no + '" name="quantities[]" class="form-control form-control-sm qty" value="'+ value.pivot.quantity +'"/></td>' +
                                '<td><input type="number" min="0" id="unit_price' + row_no + '" name="unit_prices[]" class="form-control form-control-sm unit_price" value="'+ value.pivot.unit_price +'"/></td>' +
                                '<td><input type="number" min="0" id="item_total' + row_no + '"  name="item_totals[]" class="form-control form-control-sm item_total" value="'+ value.pivot.item_total +'"/></td>' +
                                '<td><button id="remove' + row_no + '" type="button" class="close" data-dismiss="alert">&times;</button></td>' +
                                '</tr>';
                            $('#summery').before(html);

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
                               $('.item_total').trigger('change');
                               $('#items tr').length > 2 ? $("#summery").show() : $('#total').prop('value', '') && $("#summery").hide();
                               //console.log($('#items tr').length);
                           });
                           /*
                            * Subtotal on change of:
                            * quantity. 
                            */
                           $('.qty').keyup(function(e){
                               e.preventDefault();
                               var el_id = event.target.id;
                               var row_no = el_id.substr(10, );
                               $('#item_total' + row_no).prop('value', subTotal(row_no));
                               $('.item_total').trigger('change');
                           });
                           /*
                            * Subtotal on change of:
                            * unit price. 
                            */
                           $('.unit_price').keyup(function(e){
                               e.preventDefault();
                               var el_id = event.target.id;
                               var row_no = el_id.substr(10, );
                               $('#item_total' + row_no).prop('value', subTotal(row_no));
                               $('.item_total').trigger('change');
                           });
                           /*
                            * Invoice Total
                            */
                           $('#items').find('.item_total').on('change', function(){
                               var sum = 0;
                               $('.item_total').each(function(){
                               sum = + sum + + $(this).val();
                               });
                               $('#total').prop('value', sum);
                           });

                        })
                    },
                    error: function(response){
                        console.log(response);
                    },
                });
                $('#total').val(data.order.order_total);
                $("#summery").show();
                
                
            },
            error: function(data) { 
                console.log(data); 
            }
        });
        $('#select-customer').attr('checked','checked');
        $('#same_address').removeAttr('checked');
        $('#select-customer-fieldset').show();
        $('#select-customer-fieldset').removeAttr('disabled');
        $('#new-customer-fieldset').hide();
        $('#new-customer-fieldset').attr('disabled','disabled');
        //$('#add_customer').removeAttr('checked');
        $('#shipping-address').removeAttr('disabled');
        $('#closeBtn').html("Delete");
        $('#closeBtn').val("delete");
        $('#saveBtn').val("update");
        //$('#id').val('');
        $('#form-errors').hide();
        $('#orderForm').trigger("reset");
        $('#modelHeading').html("Update Order");
        //Setup modal option:
        $('#ajaxModel').modal({
            backdrop: 'static',
            keyboard: false,
            closeButton: true,
        });
        $('#closeBtn').show();
        $('#ajaxModel').modal('show');
        $('#ajaxModel').modal('handleUpdate');
        $('#order_no').trigger('focus');
    });
    
    /*
    * Datatable Delete icon click:
    * Deleting Order.
    */
    $('#dataTable').on('click', 'a.text-danger.delete', function (e){
        e.preventDefault();
        var id = $(this).attr('href');
        // Confirm box
        bootbox.dialog({
            backdrop: true,
            //centerVertical: true,
            size: '50%',
            closeButton: false,
            message: "Are you doing this by mistake? <br> If you confirm a record will be permantly deleted. Please confirm your action.",
            title: "Please confirm...",
            buttons: {
              success: {
                label: "Confirm",
                className: "btn-danger",
                callback: function() {
                    var action = '{{ route("orders.index") }}/'+id;
                    var method = 'DELETE';
                    $.ajax({
                        data: {"_token": "{{ csrf_token() }}"},
                        url: action,
                        type: method,
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            $('#dataTable').DataTable().ajax.reload();
                            //Page message:
                            $('#pageMsg').html(showMsg(data.status, data.message));
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
    });

}); //Document ready function.
</script>
@stop