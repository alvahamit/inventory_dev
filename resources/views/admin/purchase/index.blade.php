<!-- 
    Author:     Alvah Amit Halder
    Document:   Purchase's Index blade.
    Model/Data: App\Purchase
    Controller: PurchasesController
-->
@extends('theme.default')

@section('title', __('VSF-Purchases'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('List of Purchases'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">Purchases</li>
</ol>
<!--Add new button-->
<div class="form-group text-right d-print-none">
    <!--<a class="btn btn-primary right" href="{{route('purchases.create')}}">Add new</a>-->
    <button id="createNew" class="btn btn-primary right">Add new</button>
</div> 
<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Purchase Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Reference</th>
                        <th>Received on</th>
                        <th>Supplier</th>
                        <th>Type</th>
                        <th>Total</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Reference</th>
                        <th>Received on</th>
                        <th>Supplier</th>
                        <th>Type</th>
                        <th>Total</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Action</th>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated {{$lastUpdated}}</div>
</div>

<!--For Modal-->
<div class="modal fade bd-example-modal-lg my-modal" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg my-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mymodal-body">
                <!--Purchase form-->
                <form id="purchaseForm" name="purchaseForm" class="form-horizontal">
                    <div id="form-errors" class="alert alert-warning"></div>
                    @csrf
                    <!--Card-->
                    <div class="card">
                        <div class="card-body">
                            <!--hidden id input-->
                            <input type="hidden" name="id" id="id">
                            <!-- form-group -->
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <label for="ref_no">PO Ref.#</label>
                                        <input type="text" name="ref_no" id="ref_no" class="form-control" autofocus="autofocus" value="{{old('ref_no')}}">
                                    </div>
                                    <div class="col-md-3 offset-md-6">
                                        <label for="receive_date">Date:</label>
                                        <input type="date" name="receive_date" id="receive_date" class="form-control" value="{{old('receive_date')}}">
                                    </div>
                                </div>
                            </div>
                            <!-- ./form-group -->

                            <!-- form-group -->
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="user_id">Vendor:</label>
                                            <select name="user_id" id="user_id" class="custom-select">
                                                <option value="">Select vendor...</option>
                                            </select>   
                                        </div>
                                    </div>
                                    <div class="col-md-3 offset-md-6">
                                        <div class="form-group">
                                            <label for="purchase_type">Purchase Type:</label>
                                            <select name="purchase_type" id="purchase_type" class="custom-select">
                                                <option value="">Select type...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ./form-group -->
                        </div>
                    </div>
                    <!--End Card-->
                    <!--Card-->
                    <div class="card">
                        <div class="card-body">
                            <!-- form-group -->
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="table-responsive">
                                        <table class="table" id="items">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30%">Product</th>
                                                    <th style="width: 10%">Quantity</th>
                                                    <th style="width: 10%">Unit Price</th>
                                                    <th>Manufacture Date</th>
                                                    <th>Expire Date</th>
                                                    <th>Item Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="summery" style="display: none">
                                                    <td class="emptyrow"></td>
                                                    <td class="emptyrow"></td>
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
                                </div> <!-- ./form-row -->
                            </div> <!-- ./form-group -->
                            <button name="add-row" id="add-row" class="btn btn-sm btn-success float-left"><i class="fas fa-plus"></i> Add Row</button>
                        </div>
                    </div>
                    <!--End Card-->

                    <!--Form buttons-->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4 offset-md-2">
                                <button name="saveBtn" id="saveBtn" type="submit" class="btn btn-primary form-control" value="create-purchase">Save</button>
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
    .my-modal-dialog { 
        max-width: 80%; 
        width: 80%; 
    }
    
    .mymodal-body{
        background-color: lightgray;
    }
    
    .mymodal-body .card{
        margin-bottom: 1rem;
    }
    
    @media (max-width: 575px) {
        .my-modal-dialog {
            max-width: 95%; 
            width: 95% !important;
        }
        label{
            font-size: 0.8rem;
        }
    }
    
/*    .my-modal{
        text-align: center;
    }*/

    
</style>
@stop

@section('scripts')
<!--Script for this page-->
<script type="text/javascript">
    /*
     * To decode encoded as text html back to html.
     * @param {type} data
     * @returns {.document@call;createElement.value|txt.value}
     */
    function htmlDecode(data){
        var txt=document.createElement('textarea');
        txt.innerHTML=data;
        return txt.value;
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
     * This creates options for product selection: 
     * @param {int} id
     * @param {text} name
     * @param {Number} price
     * @param {text} packing
     * @returns {String}
     */
    function addOption(id,name,price,packing){
        return '<option value="'+id+'">'+name+' (Tk.'+price+'), Packing: '+packing+'</option>';
    }
    
    /*
     * This calculates item subtotal.
     * @param {Number} row_no
     * @returns {Number}
     */
    function subTotal(row_no){
        return $('#qty'+row_no).prop('value')*$('#unit_price'+row_no).prop('value');
    }
    
    /*
    * Close (modal) function:
    */
    function closeModal(){
        $('#purchseForm').trigger("reset");
        //remove all items:
        $('#items .set').remove();
        //Set data to blank:
        $('#id').val('');
        $('#ref_no').val('');
        $('#receive_date').val('');
        $('#user_id').val('');
        $('#purchase_type').val('');
        $('#total').val('');
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
                url: "{{ route('ajax-purchases.index') }}"
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'ref_no', name: 'ref_no'},
                {data: 'receive_date', name: 'receive_date'},
                {data: 'supplier', name: 'supplier'},
                {data: 'purchase_type', name: 'purchase_type'},
                {data: 'total', name: 'total'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action'},
            ],
            order:[[0,"desc"]]
        });
        
        /*
         * Setting modal options dynamically:
         */
        $.get("{{ route('ajax-purchases.create') }}", function (data) {
            $.each(data.ptypes, function( index, value ) {
                $('#purchase_type').append($("<option></option>").attr('value', value).text(value));
            });
            $.each(data.suppliers, function( index, value ) {
                $('#user_id').append($("<option></option>").attr('value', value['id']).text(value['name']));
            });
            //console.log(data);
        }); //Get function.
        
        /*
         * Create New - Click function.
         * Show/View Modal Form:
         */
        $('#createNew').click(function () {
            $('#closeBtn').html("Close");
            $('#closeBtn').val("close-modal");
            $('#saveBtn').val("create-purchase");
            $('#id').val('');
            $('#form-errors').hide();
            $('#purchseForm').trigger("reset");
            $('#modelHeading').html("Register New Purchase");
            $.get("{{ route('get.buy.ref') }}", function (data) {
                $('#ref_no').val(data);
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
            $('#ref_no').trigger('focus');
        });
        
        /*
         * Ajax Call goes to: PurchaseController@getProdData
         * This call gets product data for adding 
         * item rows.
         */
        var productOptions; //This value is set by ajax call.
        $.ajax({
            url: "{{ route('get.product.data') }}",
            type: "POST",
            data:{ 
                _token:'{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            success: function(response){
                let items = response.items;
                productOptions = response.items;
            }
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
                options += addOption(option.id,option.name,option.price,option.packing);
            });
            // Storing HTML code block in a variable
            var html = '<tr id="'+trID+'" class="set">'+
                            '<td>'+
                                '<select name="product_ids[]" class="custom-select custom-select-sm">'+
                                    '<option value="">-- Choose Product --</option>'+
                                     options+
                                '</select>'+
                            '</td>'+
                            '<td><input type="number" min="0" id="qty'+row_no+'" name="quantities[]" class="form-control form-control-sm qty"/></td>'+
                            '<td><input type="number" min="0" id="unit_price'+row_no+'" name="unit_prices[]" class="form-control form-control-sm unit_price"/></td>'+
                            '<td><input type="date" name="manufacture_dates[]" class="form-control form-control-sm"/></td>'+
                            '<td><input type="date" name="expire_dates[]" class="form-control form-control-sm"/></td>'+
                            '<td><input type="number" min="0" id="item_total'+row_no+'"  name="item_totals[]" class="form-control form-control-sm item_total"/></td>'+
                            '<td><button id="remove'+row_no+'" type="button" class="close" data-dismiss="alert">&times;</button></td>'+
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
            var mehtod;
            var action;
            if(actionType == 'create-purchase'){ 
                method = 'POST';
                action = '{{ route("ajax-purchases.store") }}';
            };
            if(actionType == 'edit-purchase'){ 
                method = 'PATCH';
                action = '{{ route("ajax-purchases.index") }}' +'/' + $('#id').val();
            };
            
            //Ajax call to save data:
            $.ajax({
                data: $('#purchaseForm').serialize(),
                url: action,
                type: method,
                dataType: 'json',
                success: function (data) {
                    console.log('Success:', data);
                    $('#form-errors').hide();
                    $('#purchseForm').trigger("reset");
                    $('#saveBtn').html('Save');
                    closeModal();
                    $('#dataTable').DataTable().ajax.reload();
                },
                error: function (data) {
                    console.log(data.responseJSON.errors);
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
            //console.log(action);
       });

        
        /*
        * ajaxModel hidden jQuery:
        * Clear all fields and reset form upon hide.
        */
        $('#ajaxModel').on('hidden.bs.modal', function (e) {
            e.preventDefault();
            closeModal();
        });
        
        
        /*
        * Close button click event: 
        */
        $('#closeBtn').click(function(e){
            e.preventDefault();
            if($('#closeBtn').val() == "close-modal"){ 
                closeModal();
            }
            if($('#closeBtn').val() == "delete-purchase"){
                $(this).html('Deleting...'); 
                // Confirm box
                bootbox.dialog({
                    backdrop: true,
                    //centerVertical: true,
                    background: 'gray',
                    size: 'md',
                    closeButton: false,
                    message: "<div class='text-center lead'>Are you doing this by mistake?<br>A record is going to be permantly deleted.<br>Please confirm your action!!!</div>",
                    title: "Please confirm...",
                    buttons: {
                      success: {
                        label: "Confirm",
                        className: "btn-danger",
                        callback: function() {
                            //I DONT KNOW WHAT TO DO HERE
                            var purchaseId = $('#id').val();
                            var action = '{{ route('ajax-purchases.index') }}'+'/' + purchaseId;
                            var method = 'DELETE';
                            $.ajax({
                                data: $('#purchaseForm').serialize(),
                                url: action,
                                type: method,
                                dataType: 'json',
                                success: function (data) {
                                    console.log('Success:', data);
                                    $('#purchaseForm').trigger("reset");
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
//                            $('#supplierForm').trigger("reset");
//                            $('#deleteBtn').html('Delete');
//                            $('#ajaxModel').modal('hide');
                        }
                      },
                      danger: {
                        label: "Cancel",
                        className: "btn-success",
                        callback: function() {
                            $('#purchaseForm').trigger("reset");
                            $('#closeBtn').html('Delete');
                            closeModal();
                        }
                      }
                    }
                  });
            }
            console.log($('#closeBtn').val());
        });
        
        /*
         * Datatable Action Column: 
         */
        $('#dataTable').on('click', 'a.edit', function (e) {
            e.preventDefault();
            $('#createNew').trigger('click');
            $('#items .set').remove();
            $('#closeBtn').html('Delete');
            $('#closeBtn').val('delete-purchase');
            $('#saveBtn').val('update-purchase');
            
            var purchaseId = $(this).attr('href');
            $.get("{{ route('ajax-purchases.index') }}" +'/' + purchaseId +'/edit', function (data) {
                $('#saveBtn').val("edit-purchase");
                $('#modelHeading').html("Edit Purchase Particulars");
                //Set data:
                $('#id').val(data['purchase']['id']);
                $('#ref_no').val(data['purchase']['ref_no']);
                $('#receive_date').val(data['purchase']['receive_date']);
                $('#user_id').val(data['purchase']['user_id']).attr('selected','selected');
                $('#purchase_type').val(data['purchase']['purchase_type']).attr('selected','selected');
                
                //Loop through items to set item data:
                var count = 1;
                $.each(data['items'], function( index, value ) {
                    $('#add-row').trigger('click');
                    var trId = 'set'+count;
                    $('#'+trId).find("td input,td select").each(function() {
                        if($(this).attr('name') == 'product_ids[]'){
                           $(this).val(data['items'][index]['pivot']['product_id']).attr('selected', 'selected'); 
                        }
                        if($(this).attr('name') == 'quantities[]'){
                           $(this).val(data['items'][index]['pivot']['quantity']); 
                        }
                        if($(this).attr('name') == 'unit_prices[]'){
                           $(this).val(data['items'][index]['pivot']['unit_price']); 
                        }
                        if($(this).attr('name') == 'manufacture_dates[]'){
                           $(this).val(data['items'][index]['pivot']['manufacture_date']); 
                        }
                        if($(this).attr('name') == 'expire_dates[]'){
                           $(this).val(data['items'][index]['pivot']['expire_date']); 
                        }
                        if($(this).attr('name') == 'item_totals[]'){
                           $(this).val(data['items'][index]['pivot']['item_total']); 
                        }
                        //console.log( $(this).attr('name') );
                    });
                    //console.log($('#'+trId));
                    count++;
                });
                $('#total').val(data['purchase']['total']);
                //console.log(data['items'][0]['pivot']);
                //console.log(data['purchase']);
            });
            //Stop following the link address:
            return false;
        }); //Action Edit
        $('#dataTable').on('click', 'a.del', function (e) {
            e.preventDefault();
            var purchaseId = $(this).attr('href');
            bootbox.dialog({
                backdrop: true,
                centerVertical: false,
                size: 'md',
                closeButton: true,
                message: "<div class='text-center lead'>Are you doing this by mistake?<br>A record is going to be permantly deleted.<br>Please confirm your action!!!</div>",
                title: "Please confirm ...",
                buttons: {
                  success: {
                    label: "Confirm",
                    className: "btn-danger",
                    callback: function() {
                        //I DONT KNOW WHAT TO DO HERE
                        var action = '{{ route('ajax-purchases.index') }}'+'/' + purchaseId;
                        var method = 'DELETE';
                        console.log(purchaseId, action, method);
                        $.ajax({
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": purchaseId
                            },
                            url: action,
                            type: method,
                            dataType: 'json',
                            success: function (data) {
                                console.log('Success:', data);
                                $('#dataTable').DataTable().ajax.reload();
                                $('#pageMsg').html(showMsg(data.status, data.message));
                                $("html, body").animate({ scrollTop: 0 }, 1000);
                            },
                            error: function (data) {
                                console.log('Error:', data);
                                $('#pageMsg').html(showMsg(false, 'Something is not right!!!'));
                            }
                        }); // Ajax call
                    }
                  },
                  danger: {
                    label: "Cancel",
                    className: "btn-success",
                    callback: function() {}
                  }
                }
              });
        }); //Action Delete
        $('#dataTable').on('click', 'a.pdf', function (e) {
            e.preventDefault();
            bootbox.alert("Function not available yet!");
        }); //Action PDF.
        
    }); //Document Ready function.
</script>
@stop