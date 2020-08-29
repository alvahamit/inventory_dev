<!-- 
    Author:     Alvah Amit Halder
    Document:   Money Receipt(MR) Index blade.
    Model/Data: App\MoneyReceipt
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
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">Money Receipt</li>
</ol>

<!--<h1>Hi!! you have following collections registered:</h1>-->
<!--Add new button-->
<div class="form-group text-right">
    <!--<a class="btn btn-primary right" href="{{route('purchases.create')}}">Add new</a>-->
    <button id="createNew" class="btn btn-primary right">Create New</button>
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
                        <th>Action</th>
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
                        <th>Action</th>
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
                                        <!--Reference input-->
                                        <div class="form-group">
                                            <label for="mr_no">MR Number:</label>
                                            <input type="text" name="mr_no" id="mr_no" autofocus="autofocus" class="form-control" value="{{old('mr_no')}}">
                                        </div>
                                        <!--Date input-->
                                        <div class="form-group">
                                            <label for="mr_date">Receive Date:</label>
                                            <input type="date" name="mr_date" id="mr_date" class="form-control" value="{{old('mr_date')}}">
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
                                            <label for="customer_id">Customer Name:</label>
                                            <select class="custom-select" name="customer_id" id="customer_id">
                                                <option value="">Select customer...</option>
                                                @foreach($customers as $customer)
                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="customer_name">Customer Name:</label>
                                            <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{old('customer_name')}}">
                                        </div>
                                        <!--organization input-->
                                        <div class="form-group">
                                            <label for="customer_company">Company:</label>
                                            <input type="text" name="customer_company" id="customer_company" class="form-control" value="{{old('customer_company')}}">
                                        </div>
                                        <!--address input-->
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label for="customer_address">Address:</label>
                                                <textarea name="customer_address" class="form-control" id="customer_address" rows="3">{!! old('customer_address') !!}</textarea>
                                            </div>
                                        </div>
                                        <!--customer_phone input-->
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="customer_phone">Phone:</label>
                                                    <input type="tel" name="customer_phone" id="customer_phone" class="form-control" value="{{old('customer_phone')}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="customer_email">Email:</label>
                                                    <input type="email" name="customer_email" id="customer_email" class="form-control" value="{{old('customer_email')}}">
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
                                            <label for="amount">Amount (BDT):</label>
                                            <input type="number" step="1" min="0" name="amount" id="amount" class="form-control" value="{{old('amount')}}">
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
                                                <label for="bank_name">Bank Name:</label>
                                                <input type="text" name="bank_name" id="bank_name" class="form-control" value="{{old('bank_name')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="cheque_no">Cheque No:</label>
                                                <input type="number" step="1" min="0" name="cheque_no" id="cheque_no" class="form-control" value="{{old('cheque_no')}}">
                                            </div>
                                        </div>
                                        <div id="bkashModeFields">
                                            <div class="form-group">
                                                <label for="bkash_tr_no">bKash Trx. No:</label>
                                                <input type="number" step="1" min="0" name="bkash_tr_no" id="bkash_tr_no" class="form-control" value="{{old('bkash_tr_no')}}">
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
<!--Page Styles-->
<style>
    .mymodal-dialog { 
        max-width: 40%; 
        width: 40% !important; 
    }
    @media (max-width: 575px) {
        .mymodal-dialog {
            max-width: 95%; 
            width: 95% !important;
        }
        #ajaxModel .modal-body{
            padding: 0;
        }
        .container-fluid{
            padding: 8px;
        }
        label{
            font-size: 0.8rem;
            margin-bottom: 0;
            padding-bottom: 0;
        }
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
            $("#customer_id").val($("#customer_id option:first").val());
            fillCustomerAddress();
            $('#customer_name').val('');
            $('#customer_id').parent().hide();
            $('#customer_name').parent().show();
        }
        if(radioVal === '2'){
            $('#customer_name').val('');
            fillCustomerAddress();
            $('#customer_name').parent().hide();
            $('#customer_id').parent().show();
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

    /*
     * Document Ready function:
     * @param {type} e
     * @returns {undefined}
     */
    $(document).ready(function(){
        //Initialize form:
        inputChooser();
        payModeChooser();
        $('#saveBtn').val('create');
        
        /*
         * Radio button click function:
         * @param {type} e
         * @returns {undefined}
         * Syntax Variation: $("input:radio[name='SomeName']")
         */
        $("input[type='radio']").click(function(){
            console.log($(this).prop('name'));
            var radioName = $(this).prop('name');
            if(radioName == 'inputChooser'){inputChooser();}
            if(radioName == 'payModeChooser'){payModeChooser();}
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
                {data: 'action', name: 'action'},
            ],
            order:[[0, "desc"]],
            columnDefs: [
                {
                    "targets": 7, // Count starts from 0.
                    "className": "text-center",
                    "width": "auto"
                },
            ]
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
                        //Sctoll to top:
                        $("#ajaxModel").animate({ scrollTop: 0 }, 1000);
                        //$('#ajaxModel').scrollTop(0);
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
        * Datatable Action column:
        */
        $('#dataTable').on('click', 'a.edit', function (e) {
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
                    $('#id').val(data.mr.id);
                    $('#mr_no').val(data.mr.mr_no);
                    $('#mr_date').val(data.mr.unformated_mr_date);
                    if(data.mr.customer_id !== null){
                        $("#selectCustomer").prop("checked", true);
                        $('#customer_id').val(data.mr.customer_id).attr('selected', 'selected');
                    } else {
                        $("#typeInCustomer").prop("checked", true);
                    }
                    inputChooser();
                    $('#customer_name').val(data.mr.customer_name);
                    $('#customer_company').val(data.mr.customer_company);
                    $('#customer_address').val(data.mr.customer_address);
                    $('#amount').val(data.mr.amount);
                    $('#bank_name').val(data.mr.bank_name);
                    $('#cheque_no').val(data.mr.cheque_no);
                    $('#bkash_tr_no').val(data.mr.bkash_tr_no);
                    if(data.mr.pay_mode == 'cash'){ $("#payModeCash").prop("checked", true); }
                    if(data.mr.pay_mode == 'cheque'){ $("#payModeCheque").prop("checked", true); }
                    if(data.mr.pay_mode == 'bkash'){ $("#payModeBkash").prop("checked", true); }
                    payModeChooser();
                    $('#customer_phone').val(data.mr.customer_phone);
                    $('#customer_email').val(data.mr.customer_email);
                },
                error: function(data) { 
                    console.log(data); 
                    //Sctoll to top:
                    $("#ajaxModel").animate({ scrollTop: 0 }, 1000);
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
        $('#dataTable').on('click', 'a.del', function (e){
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
                                //alert('Money receipt '+data.mr_no+' deleted.');
                                //Page message:
                                $('#pageMsg').html(showMsg(data.status, data.message));
                            },
                            error: function (data) {
                                console.log(data);
                                //alert('Something is not right!!!');
                                $('#pageMsg').html(showMsg(false, 'Something is not right!!!'));
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
        $('#dataTable').on('click', 'a.pdf', function (e){
            e.preventDefault();
            bootbox.alert({
                title: "Not working...",
                message: "Aparently downloading pdf via AJAX is not possible. Have to find other solution.",
                size: 'small'
            });
        });

    }); //Document ready function.
</script>
@stop