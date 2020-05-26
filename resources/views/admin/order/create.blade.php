@extends('layouts.admin')
@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">New Order</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<h1>Hi!! you can register new Sales Orders here.</h1><hr>

<!--For Modal-->
<!--<div class="modal fade bd-example-modal-lg" id="ajaxModel" aria-hidden="true">-->
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <!--<button type="button" class="close close-button topright" data-dismiss="modal" aria-hidden="true">×</button>-->
        <button id="xClose" type="button" class="close close-button topright" aria-label="Close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-header">
            <h4 class="modal-title" id="modelHeading">Order Form</h4>
        </div>
        <div class="modal-body">

            <form id="orderForm" name="orderForm" class="form-horizontal" autocomplete="off">
                <div id="form-errors" class="alert alert-warning" style="display: none"></div>
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
                                <div class="pt-3">
                                    <div class="checkbox">
                                        <label><input id="select-customer" name="select-customer" type="checkbox" value="1"> Select customer form list</label>
                                    </div>
                                </div>
                                <fieldset id="select-customer-fieldset" style="display: none" disabled="disabled">
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">Select Customer...</option>
                                        @foreach ($buyers as $buyer)
                                        <option value="{{$buyer->id}}">{{$buyer->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="pt-3">
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
                                    <div class="pt-3">
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
                                    <div class="pt-3">
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
                                </fieldset>
                                
                                <fieldset id="new-customer-fieldset">
                                    <div class="pt-3">
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
                                    <div class="pt-3">
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
                                    <div class="pt-3">
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
                                    <div class="pt-3">
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
                                    <div class="pt-3">
                                        <div class="checkbox">
                                            <label><input id="add_customer" name="add_customer" type="checkbox" value="1"> Add to customer list</label>
                                        </div>
                                    </div>
                                </fieldset> <!-- #/new-customer -->

                            </div> <!-- ,/form-group -->
                        </div> <!-- ./col-md-6 -->
                        <div class="col-md-6">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modelHeading">Shipping Address</h5>
                            </div>
                            <div class="form-group">
                                <div class="pt-3">
                                    <div class="checkbox">
                                        <label><input id="same_address" name="same_address" type="checkbox" value="1" checked="true"> Same as billing</label>
                                    </div>
                                </div>
                                <fieldset id="shipping-address" disabled="true">
                                    <div class="pt-3">
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
                                    <div class="pt-3">
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
                                    <div class="pt-3">
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
                                    <div class="pt-3">
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
                                <div class="pt-3">
                                <label class="" for="quantity_type">Quantity Type: </label>
                                <select id="quantity_type" name="quantity_type" class="custom-select col-md-6">
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
                        <table class="table table-responsive" id="items">
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
                    </div></div>
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
<!--</div>-->
<!--End of Modal-->

<!-- Address selector Modal -->


<!--Using Bootbox CDN-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
<script type="text/javascript">
    
    function fillBillingAddress(customer_name='',organization='',address_line_1='',address_line_2 =''){
        $('#select_customer_company').val(organization);
        $('#select_customer_address').val(address_line_1);
        $('#select_customer_address2').val(address_line_2);
    }
    
    function fillShippingAddress(){
        if($('#same_address').is(':checked')){
            if($('#select-customer').is(':checked')){
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
    function addOption(id,name,price,stock){
        return '<option value="'+id+'">'+name+' (Tk.'+price+'), Available: '+stock+'</option>';
    }
    
    /*
     * This calculates item subtotal.
     * @param {Number} row_no
     * @returns {Number}
     */
    function subTotal(row_no){
        return $('#qty'+row_no).prop('value')*$('#unit_price'+row_no).prop('value');
    }
    
    
    
    
    $(document).ready(function () {
        /*
         * Initialize form with:
         */
        $('#add_customer').attr("checked","true");
        getProductsByQuantityType();
        
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
                $('#add_customer').attr("checked","true");
                
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
        
        $('#customer_name').keyup(function(){
            fillShippingAddress();
        });
        $('#customer_company').keyup(function(){
            fillShippingAddress();
        });
        $('#customer_address').keyup(function(){
            fillShippingAddress();
        });
        $('#customer_address2').keyup(function(){
            fillShippingAddress();
        });
        
        /*
         * Customer select on change function:
         */
        $('#user_id').click(function(){
            var user_id = $(this).val();
            var customer_name = $('#user_id option:selected').text();
            var organization = '';
            var address_line_1 = '';
            var address_line_2 = '';
            var action = '{{ route('ajax-order.getaddress') }}';
            var method = 'GET';
            $.ajax({
                data: { "id": user_id },
                url: action,
                type: method,
                dataType: 'json',
                success: function(data) { 
                    //console.log('Success:', data); 
                    
                    var addressOptions = [];
                    $.each(data['address'], function(index, value){
                        if(data['address'][index]['pivot']['is_primary']){
                            addressOptions.push({ 'text': data['address'][index]['address'], 'value': data['address'][index]['id'] });
                        }
                    });
                    
                    if(addressOptions.length > 1){
                        bootbox.prompt({
                            title: "Address selector",
                            message: '<p>Please select an address to use from below:</p>',
                            inputType: 'radio',
                            inputOptions: addressOptions,
                            callback: function (result) {
                                //console.log(result);
                                $.each(data['address'], function(index, value){
                                    if(data['address'][index]['id'] == result){
                                        organization = data['address'][index]['organization'];
                                        address_line_1 = data['address'][index]['address'];
                                        address_line_2 = data['address'][index]['city']+' '+data['address'][index]['postal_code'];
                                        
                                        fillBillingAddress(customer_name,organization,address_line_1,address_line_2);
                                        fillShippingAddress();
                                    }
                                });
                            }
                        });
                    } else {
                        $.each(data['address'], function(index, value){
                            if(data['address'][index]['pivot']['is_primary']){
                                organization = data['address'][index]['organization'];
                                address_line_1 = data['address'][index]['address'];
                                address_line_2 = data['address'][index]['city']+' '+data['address'][index]['postal_code'];
                                
                                fillBillingAddress(customer_name,organization,address_line_1,address_line_2);
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
        function getProductsByQuantityType(){
            var quantity_type = $('#quantity_type').val();
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
            $('#items .set').remove();
            $('#total').val('');
            $("#summery").hide();
            getProductsByQuantityType();
            
        });
        
        
        /*
         * Modal "Add Row" click function:
         * Adding Dynamic Rows
         */ 
        $("#add-row").click(function(e){
            e.preventDefault();
            $("#summery").show();
            var row_count = $('#items tr').length-2;
            var row_no = +row_count + 1; 
            var trID = 'set'+ row_no; //This is the table row ID for new row.
            var options; //To store options for product choice.
            //Javascript to itarate through productOptions:
            productOptions.forEach(function(option){
                //console.log(option);
                options += addOption(option.id,option.name,option.price,option.stock);
            });
            // Storing HTML code block in a variable
            var html = '<tr id="'+trID+'" class="set">'+
                            '<td>'+
                                '<select name="product_ids[]" class="form-control">'+
                                    '<option value="">-- Choose Product --</option>'+
                                     options+
                                '</select>'+
                            '</td>'+
                            '<td><input type="number" min="0" id="qty'+row_no+'" name="quantities[]" class="form-control qty"/></td>'+
                            '<td><input type="number" min="0" id="unit_price'+row_no+'" name="unit_prices[]" class="form-control unit_price"/></td>'+
                            '<td><input type="number" min="0" id="item_total'+row_no+'"  name="item_totals[]" class="form-control item_total"/></td>'+
                            '<td><button id="remove'+row_no+'" type="button" class="close" data-dismiss="alert">&times;</button></td>'+
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
                var trID = 'set'+ row_no;
                $('#'+trID).remove();
                $('.item_total').trigger('change');
                $('#items tr').length > 2 ? $("#summery").show() : $('#total').prop('value','') && $("#summery").hide();
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
                $('#item_total'+row_no).prop('value', subTotal(row_no));
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
                $('#item_total'+row_no).prop('value', subTotal(row_no)); 
                $('.item_total').trigger('change');
            });

            /*
             * Invoice Total
             */
            $('#items').find('.item_total').on('change', function(){
                var sum =0;
                $('.item_total').each(function(){
                    sum = +sum + +$(this).val();
                });
                $('#total').prop('value',sum);
            });

        }); //#add-row
        
        
        
        /*
        * Save button click function:
        */
       $('#saveBtn').click(function(e){
            e.preventDefault();
            $(this).html('Sending..');
            var actionType = $(this).val();
            console.log(actionType);
            var mehtod;
            var action;
            if(actionType == 'create-order'){ 
                method = 'POST';
                action = '{{ route('orders.store') }}';
            };
            if(actionType == 'edit-order'){ 
                method = 'PATCH';
                action = '{{ route('orders.index') }}' +'/' + $('#id').val();
             };
            
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
                    //closeModal();
                    //$('#dataTable').DataTable().ajax.reload();
                },
                error: function (data) {
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
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    });
</script>

@stop