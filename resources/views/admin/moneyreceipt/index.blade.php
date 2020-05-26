<!-- 
    Author:     Alvah Amit Halder
    Document:   Money Receipt(MR) Index blade.
    Model/Data: App\MoneyReceipt as Customer.
    Controller: MoneyReceiptController
-->

@extends('theme.default')

@section('title', __('VSF-Money Receipt'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('List of Money Receipts'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dash') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Money Receipt</li>
</ol>

<!--<h1>Hi!! you have following collections registered:</h1>-->
<!--Add new button-->
<div class="form-group text-right">
    <!--<a class="btn btn-primary right" href="{{route('purchases.create')}}">Add new</a>-->
    <button id="createNew" class="btn btn-primary col-1 right">Create New</button>
</div> 
<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> MR Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>MR No</th>
                        <th>MR Date</th>
                        <th>Customer</th>
                        <th>Company</th>
                        <th>Amount</th>
                        <th>Pay Mode</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>MR No</th>
                        <th>MR Date</th>
                        <th>Customer</th>
                        <th>Company</th>
                        <th>Amount</th>
                        <th>Pay Mode</th>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated {{$lastUpdated}}.</div>
</div>

<!--For Modal-->
<div class="modal fade" id="ajaxModel" role="dialog" aria-labelledby="..." aria-hidden="true">
    <div class="modal-dialog mymodal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> <!-- ./modal-header -->
            <div class="modal-body mymodal-body">
                <div class="container-fluid">
                    <!-- Modal form to add and update Money Receipt (MR)  -->
                    <form id="modalForm" name="modalForm" class="form-horizontal">
                        <div id="form-errors" class="alert alert-warning" style="display: none"></div>
                        @csrf
                        <!--hidden id input-->
                        <input type="hidden" name="id" id="id">
                        <!--Accordition for customer form-->
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Money receipt reference:
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <!--name input-->
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <input 
                                                    type="text" 
                                                    name="mr_no" 
                                                    id="mr_no" 
                                                    class="form-control" 
                                                    placeholder="MR number" 
                                                    autofocus="autofocus" 
                                                    value="{{old('mr_no')}}">
                                                <label for="mr_no">MR number...</label>
                                            </div>
                                        </div>
                                        <!--email input-->
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <input 
                                                    type="date" 
                                                    name="mr_date" 
                                                    id="mr_date" 
                                                    class="form-control" 
                                                    placeholder="MR Date"
                                                    value="{{old('mr_date')}}"
                                                    >
                                                <label for="mr_date">Receipt Date...</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!--./card of General Information-->

                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Received from:
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <!--Input chooser radio button-->
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputChooser" id="typeInCustomer" value="1" checked>
                                                <label class="form-check-label" for="typeInCustomer">Fill up manually</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputChooser" id="selectCustomer" value="2">
                                                <label class="form-check-label" for="selectCustomer">Select from List</label>
                                            </div>
                                        </div>
                                        
                                        <!--customer input-->
                                        <div class="form-group">
                                            <div class="form-label-group">
                                            <select class="custom-select" name="customer_id" id="customer_id">
                                                <option value="">Select customer...</option>
                                                @foreach($customers as $customer)
                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <input 
                                                    type="text" 
                                                    name="customer_name" 
                                                    id="customer_name" 
                                                    class="form-control"
                                                    placeholder="customer name" 
                                                    value="{{old('customer_name')}}">
                                                <label for="customer_name">Customer name...</label>
                                            </div>
                                        </div>
                                        <!--organization input-->
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <input 
                                                    type="text" 
                                                    name="customer_company" 
                                                    id="customer_company" 
                                                    class="form-control"
                                                    placeholder="customer company" 
                                                    value="{{old('customer_company')}}">
                                                <label for="customer_company">Company name...</label>
                                            </div>
                                        </div>
                                        <!--address input-->
                                        <div class="form-group">
                                            <div class="form-label-group">
<!--                                                <input 
                                                    type="text" 
                                                    name="customer_address" 
                                                    id="customer_address" 
                                                    class="form-control"
                                                    placeholder="customer address" 
                                                    value="{{old('customer_address')}}">
                                                <label for="customer_address">Customer Address...</label>-->
                                                <textarea name="customer_address" class="form-control" id="customer_address" rows="3" placeholder="Customer address..."></textarea>
                                            </div>
                                        </div>
                                        <!--customer_phone input-->
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-label-group">
                                                        <input 
                                                            type="tel"
                                                            name="customer_phone" 
                                                            id="customer_phone" 
                                                            class="form-control"
                                                            placeholder="customer_phone" 
                                                            value="{{old('customer_phone')}}">
                                                        <label for="customer_phone">Phone...</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-label-group">
                                                        <input 
                                                            type="email" 
                                                            name="customer_email" 
                                                            id="customer_email" 
                                                            class="form-control"
                                                            placeholder="customer_email" 
                                                            value="{{old('customer_email')}}">
                                                        <label for="customer_email">Email...</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!--./card-body -->
                                </div> <!--./collapse-->
                            </div> <!--./card of Address Fields-->
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Payment Information:
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <!--MR Amount-->
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <input 
                                                    type="number"
                                                    step="1"
                                                    min="0"
                                                    name="amount" 
                                                    id="amount" 
                                                    class="form-control"
                                                    placeholder="amount" 
                                                    value="{{old('amount')}}">
                                                <label for="amount">Received amount...</label>
                                            </div>
                                        </div>
                                        <!--Payment method-->
                                        <!--Input chooser radio button-->
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="payModeChooser" id="payModeCash" value="1" checked>
                                                <label class="form-check-label" for="payModeCash">Cash</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="payModeChooser" id="payModeCheque" value="2">
                                                <label class="form-check-label" for="payModeCheque">Cheque</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="payModeChooser" id="payModeBkash" value="3">
                                                <label class="form-check-label" for="payModeBkash">bKash</label>
                                            </div>
                                        </div>
                                        <!-- Pay mode details -->
                                        <div id="chequeModeFields">
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <input 
                                                        type="text"
                                                        name="bank_name" 
                                                        id="bank_name" 
                                                        class="form-control"
                                                        placeholder="bank_name" 
                                                        value="{{old('bank_name')}}">
                                                    <label for="bank_name">Bank name...</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <input 
                                                        type="number"
                                                        step="1"
                                                        min="0"
                                                        name="cheque_no" 
                                                        id="cheque_no" 
                                                        class="form-control"
                                                        placeholder="cheque_no" 
                                                        value="{{old('cheque_no')}}">
                                                    <label for="cheque_no">Cheque no...</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="bkashModeFields">
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <input 
                                                        type="number"
                                                        step="1"
                                                        min="0"
                                                        name="bkash_tr_no" 
                                                        id="bkash_tr_no" 
                                                        class="form-control"
                                                        placeholder="bkash_tr_no" 
                                                        value="{{old('bkash_tr_no')}}">
                                                    <label for="bkash_tr_no">bKash trx no...</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!--./card-body-->
                                </div> <!--./collapse-->
                            </div> <!--./card -->
                        </div>

                        <!--Save and Delete buttons-->
                        <div class="form-group pt-3">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary form-control" id="saveBtn">Save</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-danger form-control" id="closeBtn">Close</button>
                                </div>
                            </div>
                        </div>    
                    </form>
                </div> <!-- ./container-fluid -->
            </div> <!-- ./modal-body -->
        </div> <!-- ./modal-content -->
    </div> <!-- ./modal-dialog -->
</div> <!-- #/ajaxModel -->
<style>
    .mymodal-dialog { 
        max-width: 30%; 
        width: 30% !important; 
    }
    .mymodal-body{
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
</style>  

@stop

@section('scripts')
<!--Script for this page-->
<script type="text/javascript">
    /*
     * For later use:
     * @param {type} customer_name
     * @param {type} organization
     * @param {type} address_line_1
     * @param {type} address_line_2
     * @returns {undefined}
     */
    function fillCustomerAddress(company = '', address = '', email = '', phone = ''){
        $('#customer_company').val(company);
        $('#customer_address').val(address);
        $('#customer_email').val(email);
        $('#customer_phone').val(phone);
    }

    /*
    * Close (modal) function:
    */
    function closeModal(){
       $('#modalForm').trigger("reset");
       $('#ajaxModel').modal('hide');
       inputChooser();
       payModeChooser();
    } 

    /*
     * Input Chooser Radio button function (Customer):
     * @returns {undefined}
     */
    function inputChooser(){
        var radioVal = $("input[name='inputChooser']:checked").val();
        if(radioVal === '1'){
            $('#customer_id').hide();
            $('#customer_name').show();
        }
        if(radioVal === '2'){
            $('#customer_name').hide();
            $('#customer_id').show();
        }
    }

    /*
     * Input Chooser Radio button function (Paymode):
     * @returns {undefined}
     */
    function payModeChooser(){
        var radioVal = $("input[name='payModeChooser']:checked").val();
        if(radioVal === '1'){
            $('#chequeModeFields').hide();
            $('#bank_name').val('');
            $('#cheque_no').val('');
            $('#bkashModeFields').hide();
            $('#bkash_tr_no').val('');
        }
        if(radioVal === '2'){
            $('#chequeModeFields').show();
            $('#bkashModeFields').hide();
            $('#bkash_tr_no').val('');
        }
        if(radioVal === '3'){
            $('#chequeModeFields').hide();
            $('#bank_name').val('');
            $('#cheque_no').val('');
            $('#bkashModeFields').show();
        }
    }

    /*
     * Document Ready function:
     * @param {type} e
     * @returns {undefined}
     */
    $(document).ready(function(){
        inputChooser();
        payModeChooser();
        $('#saveBtn').val('create');
        /*
         * Radio button click function:
         * @param {type} e
         * @returns {undefined}
         */
        $("input[type='radio']").click(function(){
            inputChooser();
            payModeChooser();
        });

        /*
         * Initialize Yajra on document table.
         * @param {type} e
         * @returns {undefined}
         */
        $('#dataTable').DataTable({
            processing: true,
            servirSide: true,
            ajax: {
            url: "{{ route('mrs.index') }}",
            },
            columns: [
            {data: 'id', name: 'id'},
            {data: 'mr_no', name: 'mr_no'},
            {data: 'mr_date', name: 'mr_date'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'customer_company', name: 'customer_company'},
            {data: 'amount', name: 'amount'},
            {data: 'pay_mode', name: 'pay_mode'},
            ],
            order:[[0, "desc"]],
        });

        /*
         * Create new Money Receipt (MR):
         * Show/View Modal Form.
         * @param {type} e
         * @returns {undefined}
         */
        $('#createNew').click(function () {
            $('#closeBtn').html("Close");
            $('#closeBtn').val("close-modal");
            $('#saveBtn').val("create");
            $('#id').val('');
            $('#form-errors').hide();
            $('#modalForm').trigger("reset");
            inputChooser();
            payModeChooser();
            $('#modelHeading').html("New Money Receipt (MR)");
            //Setup modal option:
            $('#ajaxModel').modal({
            backdrop: 'static',
                    keyboard: false,
                    closeButton: true,
            });
            $('#closeBtn').show();
            $('#ajaxModel').modal('show');
            $('#ajaxModel').modal('handleUpdate');
        }); //Create New - Button click function.


        /*
        * xClose icon click event:
        */
        $('#xClose').click(function(e){
            e.preventDefault();
            closeModal();
        });


        /*
         * Customer select on change function:
         */
        $('#customer_id').click(function(){
            var user_id = $(this).val();
            var customer_name = $('option:selected', this).text();
            var company = '';
            var address = '';
            var email = '';
            var phone = '';
            var action = '{{ route("ajax-order.getaddress") }}';
            var method = 'GET';
            $.ajax({
            data: { "id": user_id },
                    url: action,
                    type: method,
                    dataType: 'json',
                    success: function(data) {
                        console.log('Success:', data); //Log success data for developer.
                        $('#customer_name').val(customer_name);
                        company = data['buyer']['organization'];
                        //get contact nos.
                        var contactArray = [];
                        $.each(data['contacts'], function(index, value){
                            var ph = data['contacts'][index]['country_code'] +'-' 
                                    + data['contacts'][index]['city_code'] + '-' 
                                    + data['contacts'][index]['number'];
                            contactArray.push(ph);
                        });
                        phone = contactArray.toString();
                        company = data['buyer']['organization'];
                        email = data['buyer']['email'];
                        //get address/es and choose if many.
                        var addressOptions = [];
                        $.each(data['address'], function(index, value){
                            if (data['address'][index]){
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
                                        $.each(data['address'], function(index, value){
                                            
                                            if (data['address'][index]['id'] == result){
                                                address = data['address'][index]['address'] +'\r\n' 
                                                        + data['address'][index]['city'] + ' ' 
                                                        + data['address'][index]['postal_code'];
                                            }
                                            fillCustomerAddress(company, address, email, phone); //Out of bootbox this funciton will not work.
                                        });
                                    }
                            });
                        } else {
                            $.each(data['address'], function(index, value){
                                address = data['address'][index]['address'] +'\r\n' 
                                        + data['address'][index]['city'] + ' ' 
                                        + data['address'][index]['postal_code'];
                                fillCustomerAddress(company, address, email, phone);
                            });
                        }
                    },
                    error: function(data) { console.log('Error:', data); }
            });
        });
        

        /*
         * Save button click function:
         */
        $('#saveBtn').click(function(e){
            e.preventDefault();
            $(this).html('Sending..');
            var actionType = $(this).val();
            var mehtod;
            var action;
            if (actionType == 'create'){
                method = 'POST';
                action = '{{ route("mrs.store") }}';
            };
            if (actionType == 'update'){
                method = 'PATCH';
                action = '{{ route("mrs.index") }}' + '/' + $('#id').val();
            };

            //Ajax call to save data:
            $.ajax({
            data: $('#modalForm').serialize(),
                    url: action,
                    type: method,
                    dataType: 'json',
                    success: function (data) {
                        console.log('Success:', data);
                        $('#form-errors').hide();
                        $('#modalForm').trigger("reset");
                        $('#saveBtn').html('Save');
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
                    //centerVertical: true,
                    size: 'small',
                    closeButton: false,
                    message: "Are you doing this by mistake? <br> If you confirm a record will be permantly deleted. Please confirm your action.",
                    title: "Please confirm...",
                    buttons: {
                      success: {
                        label: "Confirm",
                        className: "btn-danger",
                        callback: function() {
                            var id = $('#id').val();
                            var action = '{{ route("mrs.index") }}/' + id;
                            var method = 'DELETE';
                            $.ajax({
                                data: $('#modalForm').serialize(),
                                url: action,
                                type: method,
                                dataType: 'json',
                                success: function (data) {
                                    console.log('Success:', data);
                                    $('#modalForm').trigger("reset");
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
                            $('#modalForm').trigger("reset");
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
        * Editing MR.
        */
        $('#dataTable').on('click', 'a.text-warning.edit', function (e) {
            e.preventDefault();
            var id = $(this).attr('href');
            //console.log(id);
            var action = '{{ route("mr.ajax.get") }}';
            var method = 'GET';
            $.ajax({
                data: { "id": id },
                url: action,
                type: method,
                dataType: 'json',
                success: function(data) { 
                    console.log(data);
                    //blank: $('#').val(data.mr.);
                    $('#id').val(data.mr.id);
                    $('#mr_no').val(data.mr.mr_no);
                    $('#mr_date').val(data.mr.unformated_mr_date);
                    $('#customer_name').val(data.mr.customer_name);
                    $('#customer_company').val(data.mr.customer_company);
                    $('#customer_address').val(data.mr.customer_address);
                    $('#amount').val(data.mr.amount);
                    $('#bank_name').val(data.mr.bank_name);
                    $('#cheque_no').val(data.mr.cheque_no);
                    $('#bkash_tr_no').val(data.mr.bkash_tr_no);
                    if(data.mr.customer_id !== null){
                        $("#selectCustomer").prop("checked", true);
                        $('#customer_id').val(data.mr.customer_id).attr('selected', 'selected');
                    } else {
                        $("#typeInCustomer").prop("checked", true);
                    }
                    inputChooser();
                    if(data.mr.pay_mode == 'cash'){ $("#payModeCash").prop("checked", true); }
                    if(data.mr.pay_mode == 'cheque'){ $("#payModeCheque").prop("checked", true); }
                    if(data.mr.pay_mode == 'bkash'){ $("#payModeBkash").prop("checked", true); }
                    payModeChooser();
                    $('#customer_phone').val(data.mr.customer_phone);
                    $('#customer_email').val(data.mr.customer_email);
                    
                    //$('#quantity_type').val(data.order.quantity_type).attr('selected', 'selected').trigger('change');

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
            $('#form-errors').hide();
            $('#modalForm').trigger("reset");
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
        * Deleting MR.
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
                        var action = '{{ route("mrs.index") }}/'+id;
                        var method = 'DELETE';
                        $.ajax({
                            data: {"_token": "{{ csrf_token() }}"},
                            url: action,
                            type: method,
                            dataType: 'json',
                            success: function (data) {
                                console.log(data);
                                $('#dataTable').DataTable().ajax.reload();
                                alert('Money receipt '+data.mr_no+' deleted.');
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
                        $('#closeBtn').html('Delete');
                        $('#ajaxModel').modal('hide');
                    }
                  }
                }
              }) //Confirm Box

        });

    }); //Document ready function.
</script>
@stop