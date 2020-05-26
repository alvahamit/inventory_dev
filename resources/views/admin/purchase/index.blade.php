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
        <a href="{{ route('admin.dash') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Purchases</li>
</ol>
<!--<h1>Hi!! you have made following purchases:</h1>-->
<!--Add new button-->
<div class="form-group text-right">
    <!--<a class="btn btn-primary right" href="{{route('purchases.create')}}">Add new</a>-->
    <button id="createNew" class="btn btn-primary col-1 right">Add new</button>
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
            <!--<button type="button" class="close close-button topright" data-dismiss="modal" aria-hidden="true">×</button>-->
            <button id="xClose" type="button" class="close close-button topright" aria-label="Close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                
                <form id="purchaseForm" name="purchaseForm" class="form-horizontal">
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
                                           name="ref_no"
                                           id="ref_no" 
                                           class="form-control" 
                                           placeholder="Reference no." 
                                           autofocus="autofocus"
                                           value="{{old('ref_no')}}">
                                    <label for="ref_no">Purchase reference no#</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="date"
                                           name="receive_date"
                                           id="receive_date" 
                                           class="form-control"
                                           placeholder="receive_date"
                                           value="{{old('receive_date')}}">
                                    <label for="receive_date">Receive Date</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./form-group -->

                    <!-- form-group -->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="user_id"
                                            id="user_id"
                                            class="form-control">
                                        <option value="">Select Supplier...</option>
                                    </select>   
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="purchase_type"
                                            id="purchase_type"
                                            class="form-control">
                                        <option value="">Purchase Type...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./form-group -->

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
        display: inline-block; 
    }
    .my-modal{
        text-align: center;
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
                {data: 'ref_no', 
                    name: 'ref_no',
                    render: function(data){return htmlDecode(data);}
                },
                {data: 'receive_date', name: 'receive_date'},
                {data: 'supplier', name: 'supplier'},
                {data: 'purchase_type', name: 'purchase_type'},
                {data: 'total', name: 'total'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
            ],
            order:[[0,"desc"]]
        });
        
        /*
         * Setting modal options dynamically:
         */
        $.get("{{ route('ajax-purchases.create') }}", function (data) {
            var ptype = data.purchase_type;
            var suppliers = data.suppliers;
            $.each(ptype, function( index, value ) {
                $('#purchase_type').append($("<option></option>").attr('value', value).text(value));
            });
            $.each(suppliers, function( index, value ) {
                $('#user_id').append($("<option></option>").attr('value', value['id']).text(value['name']));
            });
            //console.log(data.suppliers);
        }); //Get function.
        
        /*
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
        }); //Create New - Click function.
        
        /*
         * Ajax Call goes to: PurchaseController@getProdData
         * This call gets product data for adding 
         * item rows.
         */
        var productOptions; //This value is set by ajax call.
        $.ajax({
            url: "/v2/purchases/getProdData",
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
                                '<select name="product_ids[]" class="form-control">'+
                                    '<option value="">-- Choose Product --</option>'+
                                     options+
                                '</select>'+
                            '</td>'+
                            '<td><input type="number" min="0" id="qty'+row_no+'" name="quantities[]" class="form-control qty"/></td>'+
                            '<td><input type="number" min="0" id="unit_price'+row_no+'" name="unit_prices[]" class="form-control unit_price"/></td>'+
                            '<td><input type="date" name="manufacture_dates[]" class="form-control"/></td>'+
                            '<td><input type="date" name="expire_dates[]" class="form-control"/></td>'+
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
            var mehtod;
            var action;
            if(actionType == 'create-purchase'){ 
                method = 'POST';
                action = '{{ route('ajax-purchases.store') }}';
            };
            if(actionType == 'edit-purchase'){ 
                method = 'PATCH';
                action = '{{ route('ajax-purchases.index') }}' +'/' + $('#id').val();
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
        
        /*
        * xClose icon click event:
        */
        $('#xClose').click(function(e){
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
                    message: "Are you doing this by mistake? <br> If you confirm a record will be permantly deleted. Please confirm your action.",
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
         * Data Table icons click functions: 
         */
        //Edit Icon:
        $('#dataTable').on('click', 'a.text-warning.edit', function (e) {
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
        });
        
        //Delete Icon:
        $('#dataTable').on('click', 'a.text-danger.delete', function (e) {
            e.preventDefault();
            var purchaseId = $(this).attr('href');
            var reference = $(this).parent().parent().text();
            console.log( $(this).parent().parent().text() );
            //console.log($(this).attr('href'));
            
            // Confirm box
                bootbox.dialog({
                    backdrop: true,
                    centerVertical: true,
                    size: 'md',
                    closeButton: true,
                    message: "You are about to delete <strong>"+reference+"</strong>. Are you doing this by mistake? Records will be permantly deleted. <br>Please confirm your action.",
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
                                },
                                error: function (data) {
                                    console.log('Error:', data);
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
        });
        
        
    }); //Document Ready function.
</script>
@stop