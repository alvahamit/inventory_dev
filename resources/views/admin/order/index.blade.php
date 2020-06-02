<!-- 
    Author:     Alvah Amit Halder
    Document:   Users's Index blade.
    Model/Data: App\User
    Controller: UsersController
-->

@extends('theme.default')

@section('title', __('VSF-Orders'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('List of Orders'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')


<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dash') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Orders</li>
</ol>

<!--<h1>Hi!! you have following orders:</h1>-->
<!--Add new button-->
<div class="form-group text-right d-print-none">
    <!--<a class="btn btn-primary right" href="{{route('purchases.create')}}">Add new</a>-->
    <button id="createNew" class="btn btn-primary col-1 right">New Order</button>
</div> 
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
            <!--<button type="button" class="close close-button topright" data-dismiss="modal" aria-hidden="true">×</button>-->
            <div class="float-right">
                <button id="xClose" type="button" class="close close-button pr-2 pt-1" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>    
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">

                <form id="orderForm" name="orderForm" class="form-horizontal" autocomplete="off">
                    <div id="form-errors" class="alert alert-warning"></div>
                    @csrf
                    <!--hidden id input-->
                    <input type="hidden" name="id" id="id">
                    <!-- form-group -->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" 
                                           name="order_no"
                                           id="order_no" 
                                           class="form-control" 
                                           placeholder="Order no." 
                                           autofocus="autofocus"
                                           value="{{old('order_no')}}">
                                    <label for="order_no">Order Number...</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="date"
                                           name="order_date"
                                           id="order_date" 
                                           class="form-control"
                                           placeholder="order_date"
                                           value="{{old('order_date')}}">
                                    <label for="order_date">Order Date</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./form-group -->

                    <!-- form-group -->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modelHeading">Billing Address</h5>
                                </div>
                                <div class="form-group">
                                    <div class="pt-1">
                                        <div class="checkbox">
                                            <label><input id="select-customer" name="select-customer" type="checkbox" value="1"> Select customer form list</label>
                                        </div>
                                    </div>
                                    <fieldset id="select-customer-fieldset" style="display: none" disabled="disabled">
                                        <select name="user_id" id="user_id" class="form-control">
                                            <option value="">Select Customer...</option>
                                        </select>
                                        <div class="pt-1">
                                            <div class="form-label-group">
                                                <input type="text" 
                                                       name="select_customer_company"
                                                       id="select_customer_company" 
                                                       class="form-control" 
                                                       placeholder="Customer company" 
                                                       value="{{old('select_customer_company')}}">
                                                <label for="select_customer_company">Company name...</label>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <div class="form-label-group">
                                                <input type="text" 
                                                       name="select_customer_address"
                                                       id="select_customer_address" 
                                                       class="form-control" 
                                                       placeholder="Customer address" 
                                                       value="{{old('select_customer_address')}}">
                                                <label for="select_customer_address">Customer address...</label>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <div class="form-label-group">
                                                <input type="text" 
                                                       name="select_customer_address2"
                                                       id="select_customer_address2" 
                                                       class="form-control" 
                                                       placeholder="Customer address line 2" 
                                                       value="{{old('select_customer_address2')}}">
                                                <label for="select_customer_address2">Address line 2...</label>
                                            </div>
                                        </div>
                                    </fieldset> <!-- #/select-customer-fieldset -->

                                    <fieldset id="new-customer-fieldset">
                                        <div class="pt-1">
                                            <div class="form-label-group">
                                                <input type="text" 
                                                       name="customer_name"
                                                       id="customer_name" 
                                                       class="form-control" 
                                                       placeholder="Customer name" 
                                                       value="{{old('customer_name')}}">
                                                <label for="customer_name">Customer name...</label>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <div class="form-label-group">
                                                <input type="text" 
                                                       name="customer_company"
                                                       id="customer_company" 
                                                       class="form-control" 
                                                       placeholder="Customer company" 
                                                       value="{{old('customer_company')}}">
                                                <label for="customer_company">Company name...</label>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <div class="form-label-group">
                                                <input type="text" 
                                                       name="customer_address"
                                                       id="customer_address" 
                                                       class="form-control" 
                                                       placeholder="Customer address" 
                                                       value="{{old('customer_address')}}">
                                                <label for="customer_address">Customer address...</label>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <div class="form-label-group">
                                                <input type="text" 
                                                       name="customer_address2"
                                                       id="customer_address2" 
                                                       class="form-control" 
                                                       placeholder="Customer address line 2" 
                                                       value="{{old('customer_address2')}}">
                                                <label for="customer_address2">Address line 2...</label>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <div class="checkbox">
                                                <label><input id="add_customer" name="add_customer" type="checkbox" value="1"> Add to customer list</label>
                                            </div>
                                        </div>
                                    </fieldset> <!-- #/new-customer-fieldset -->

                                </div> <!-- ,/form-group -->
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
                                    <fieldset id="shipping-address" disabled="true">
                                        <div class="pt-1">
                                            <div class="form-label-group">
                                                <input type="text" 
                                                       name="customer_name_shipping"
                                                       id="customer_name_shipping" 
                                                       class="form-control" 
                                                       placeholder="Customer name for shipping" 
                                                       value="{{old('customer_name_shipping')}}">
                                                <label for="customer_name_shipping">Name...</label>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <div class="form-label-group">
                                                <input type="text" 
                                                       name="shipping_company"
                                                       id="shipping_company" 
                                                       class="form-control" 
                                                       placeholder="Shipping company" 

                                                       value="{{old('shipping_company')}}">
                                                <label for="shipping_company">Company...</label>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <div class="form-label-group">
                                                <input type="text" 
                                                       name="shipping_address"
                                                       id="shipping_address" 
                                                       class="form-control" 
                                                       placeholder="Shipping address" 
                                                       value="{{old('shipping_address')}}">
                                                <label for="shipping_address">Address line 1...</label>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <div class="form-label-group">
                                                <input type="text" 
                                                       name="shipping_address2"
                                                       id="shipping_address2" 
                                                       class="form-control" 
                                                       placeholder="Shipping address line 2" 
                                                       value="{{old('shipping_address2')}}">
                                                <label for="shipping_address2">Address line 2...</label>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <!--Unit chooser-->
                                    <div class="pt-1">
                                        <label class="col-form-label" for="quantity_type">Quantity Type: </label>
                                        <select id="quantity_type" name="quantity_type" class="custom-select form-control col-md-5">
                                            <option value="">Wholesale Packing</option>
                                            <option value="pcs">Retail Unit/Pcs</option>
                                            <option value="weight">Weight/Volume</option>
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- ./col-md-6 -->
                        </div> <!-- ./form-row -->
                    </div>
                    <!-- ./form-group -->

                    <!-- form-group -->
                    <div class="form-group">
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
                                                <input type="number"
                                                       min="0"
                                                       id="total"
                                                       name="total"
                                                       class="form-control" 
                                                       placeholder="total" > 
                                            </td>
                                            <td class="emptyrow"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> <!-- ./table-responsive -->
                        </div> <!-- ./form-row -->
                    </div> <!-- ./form-group -->
                    <!--Form buttons-->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4">
                                <button name="add-row" id="add-row" class="btn btn-success form-control">Add Row</button>
                            </div>
                            <div class="col-md-4">
                                <button name="saveBtn" id="saveBtn" type="submit" class="btn btn-primary form-control" value="create-order">Save</button>
                            </div>
                            <div class="col-md-4">
                                <button name="closeBtn" id="closeBtn" class="btn btn-danger form-control">Close</button>
                            </div>
                        </div>
                    </div>
                    <!--End Form buttons-->

                </form>
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

    .close-button {
        border: none;
        display: inline-block;

        padding: 8px 16px;
        vertical-align: middle;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        background-color: inherit;
        text-align: center;
        cursor: pointer;
        white-space: nowrap;
    }

    .topright {
        position: absolute;
        right: 0;
        top: 0;
        margin-right: 5px;
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

function fillBillingAddress(customer_name = '', organization = '', address_line_1 = '', address_line_2 = ''){
    $('#select_customer_company').val(organization);
    $('#select_customer_address').val(address_line_1);
    $('#select_customer_address2').val(address_line_2);
}

function fillShippingAddress(){
    if ($('#same_address').is(':checked')){
        if ($('#select-customer').is(':checked')){
            $('#customer_name_shipping').val($('#user_id option:selected').text());
            $('#shipping_company').val($('#select_customer_company').val());
            $('#shipping_address').val($('#select_customer_address').val());
            $('#shipping_address2').val($('#select_customer_address2').val());
        } else {
            $('#customer_name_shipping').val($('#customer_name').val());
            $('#shipping_company').val($('#customer_company').val());
            $('#shipping_address').val($('#customer_address').val());
            $('#shipping_address2').val($('#customer_address2').val());
        }
    } else {
        clearShippingFields();
    }
}

function clearShippingFields(){
    $('#customer_name_shipping').val('');
    $('#shipping_company').val('');
    $('#shipping_address').val('');
    $('#shipping_address2').val('');
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
* Close (modal) function:
*/
function closeModal(){
   $('#orderForm').trigger("reset");
   //remove all items:
   $('#items .set').remove();
   //Set data to blank:
   $('#id').val('');
//       $('#ref_no').val('');
//       $('#receive_date').val('');
//       $('#user_id').val('');
//       $('#purchase_type').val('');
//       $('#total').val('');
   $('#ajaxModel').modal('hide');
} 


$(document).ready(function(){
    /*
     * Initialize Yajra on document table.
     */
    $('#dataTable').DataTable({
    processing: true,
            servirSide: true,
            ajax: {
            url: "{{ route('orders.index') }}",
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
    $.get("{{ route('orders.create') }}", function (data) {
        //var ptype = data.purchase_type;
        var buyers = data.buyers;
        //            $.each(ptype, function( index, value ) {
        //                $('#purchase_type').append($("<option></option>").attr('value', value).text(value));
        //            });
        $.each(buyers, function(index, value) {
            $('#user_id').append($("<option></option>").attr('value', value['id']).text(value['name']));
        });
        //console.log(data.suppliers);
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
        $('#modelHeading').html("Create New Order");
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
    });


    /*
    * xClose icon click event:
    */
    $('#xClose').click(function(e){
        e.preventDefault();
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
    $('#customer_address2').keyup(function(){ fillShippingAddress(); })
    /*
     * Customer select on change function:
     */
    $('#user_id').click(function(){
        var user_id = $(this).val();
        var customer_name = $('#user_id option:selected').text();
        var organization = '';
        var address_line_1 = '';
        var address_line_2 = '';
        var action = '{{ route("ajax-order.getaddress") }}';
        var method = 'GET';
        $.ajax({
        data: { "id": user_id },
                url: action,
                type: method,
                dataType: 'json',
                success: function(data) {
                //console.log('Success:', data); 
                organization = data['buyer']['organization'];
                var addressOptions = [];
                $.each(data['address'], function(index, value){
                if (data['address'][index]['pivot']['is_primary']){
                addressOptions.push({ 'text': data['address'][index]['address'], 'value': data['address'][index]['id'] });
                }
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
                        address_line_1 = data['address'][index]['address'];
                        address_line_2 = data['address'][index]['city'] + ' ' + data['address'][index]['postal_code'];
                        fillBillingAddress(customer_name, organization, address_line_1, address_line_2);
                        fillShippingAddress();
                        }
                        });
                        }
                });
                } else {
                $.each(data['address'], function(index, value){
                if (data['address'][index]['pivot']['is_primary']){
                address_line_1 = data['address'][index]['address'];
                address_line_2 = data['address'][index]['city'] + ' ' + data['address'][index]['postal_code'];
                fillBillingAddress(customer_name, organization, address_line_1, address_line_2);
                fillShippingAddress();
                }
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
                '<select name="product_ids[]" class="form-control">' +
                '<option value="">-- Choose Product --</option>' +
                options +
                '</select>' +
                '</td>' +
                '<td><input type="number" min="0" id="qty' + row_no + '" name="quantities[]" class="form-control qty"/></td>' +
                '<td><input type="number" min="0" id="unit_price' + row_no + '" name="unit_prices[]" class="form-control unit_price"/></td>' +
                '<td><input type="number" min="0" id="item_total' + row_no + '"  name="item_totals[]" class="form-control item_total"/></td>' +
                '<td><button id="remove' + row_no + '" type="button" class="close" data-dismiss="alert">&times;</button></td>' +
                '</tr>';
        //$('#items').append(html);  
        //$('#items').find('tr:last').prev().after(html);
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
            action = '{{ route("orders.store") }}';
        };
        if (actionType == 'update'){
            method = 'PATCH';
            action = '{{ route("orders.index") }}' + '/' + $('#id').val();
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
                    $('#form-errors').hide();
                    $('#orderForm').trigger("reset");
                    $('#saveBtn').html('Save');
                    $('#shipping-address').attr("disabled", "disabled");
                    closeModal();
                    $('#dataTable').DataTable().ajax.reload();
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
                $('#customer_name').val(data.order.customer_name);
                $('#customer_company').val(data.order.customer_company);
                $('#customer_address').val(data.order.customer_address1);
                $('#customer_address2').val(data.order.customer_address2);
                $('#customer_name_shipping').val(data.order.shipp_to_name);
                $('#shipping_company').val(data.order.shipp_to_company);
                $('#shipping_address').val(data.order.shipping_address1);
                $('#shipping_address2').val(data.order.shipping_address2);
                $('#quantity_type').val(data.order.quantity_type).attr('selected', 'selected').trigger('change');
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
                                '<select name="product_ids[]" class="form-control">' +
                                '<option value="">-- Choose Product --</option>' +
                                options +
                                '</select>' +
                                '</td>' +
                                '<td><input type="number" min="0" id="qty' + row_no + '" name="quantities[]" class="form-control qty" value="'+ value.pivot.quantity +'"/></td>' +
                                '<td><input type="number" min="0" id="unit_price' + row_no + '" name="unit_prices[]" class="form-control unit_price" value="'+ value.pivot.unit_price +'"/></td>' +
                                '<td><input type="number" min="0" id="item_total' + row_no + '"  name="item_totals[]" class="form-control item_total" value="'+ value.pivot.item_total +'"/></td>' +
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

        $('#select-customer-fieldset').hide();
        $('#select-customer-fieldset').attr('disabled', 'disabled');
        $('#new-customer-fieldset').show();
        $('#new-customer-fieldset').removeAttr('disabled');
        $('#add_customer').removeAttr('checked');
        $('#same_address').removeAttr('checked');
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
                            alert('Order no. '+data.order+' deleted.');
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