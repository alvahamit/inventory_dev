<!-- 
    Author:     Alvah Amit Halder
    Document:   Stockhausen blade.
    Model/Data: Nil
    Controller: Ajax/StockController
-->

@extends('theme.default')

@section('title', __('VSF-Stock'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Product Stock Status'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dash') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Stock</li>
</ol>

<!--<h1>Hi!! Here is your stock status:</h1>-->
<!--Add additional filters-->
<div class="form-group text-right">
    <!--Store chooser-->
    <label class="" for="store-selector"> Store chooser: </label>
    <select id="store-selector" name="store-selector" class="custom-select col-md-2">
        <option value="">All Stores</option>
        @foreach ($stores as $store)
        <option value="{{$store->id}}">{{$store->name}}</option>
        @endforeach
    </select>
    <!--Format chooer-->
    <label class="" for="stock-formatter"> Format chooser: </label>
    <select id="stock-formatter" name="stock-formatter" class="custom-select col-md-2">
        <option value="">View by Packing</option>
        <option value="pcs">View by Unit/Pcs</option>
        <option value="weight">View by Weight</option>
    </select>
</div> 
<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Stock Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Country</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Stock</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Country</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Stock</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated {{$lastUpdated}}</div>
</div>
@stop

@section('scripts')
<!--Script for this page-->
<script type="text/javascript">
 
    $(document).ready(function(){
        
        fill_datatable();
        
        /*
         * Datatable initialization function. 
         */
        function fill_datatable(formatter = '', store_id = ''){
            var dataTable = $('#dataTable').DataTable({
                processing: true,
                servirSide: true,
                ajax: {
                    url: "{{ route('ajax-stock.index') }}",
                    data: {'formatter':formatter, 'store_id': store_id},
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {data: 'brand', name: 'brand'},
                    {data: 'country', name: 'country'},
                    {data: 'price', name: 'price'},
                    {data: 'stock', name: 'stock'},
                ]
            });
        };
        
        
        /*
         * Filter function: 
         */
        function filter_datatable(){
            var formatter = $('#stock-formatter').val();
            var store_id = $('#store-selector').val();
            $('#dataTable').DataTable().destroy();
            fill_datatable(formatter, store_id);
        }
        
        $('#stock-formatter').change(function(){
            filter_datatable();
        });
        
        $('#store-selector').change(function(){
            filter_datatable();
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
        * Save button click function:
        */
       $('#saveBtn').click(function(e){
            e.preventDefault();
            $(this).html('Sending..');
            var actionType = $(this).val();
            console.log(actionType);
            var mehtod;
            var action;
            if(actionType == 'create-purchase'){ 
                method = 'POST';
                action = '{{ route('ajax-purchases.store') }}';
                console.log(method);
            };
            if(actionType == 'edit-purchase'){ 
                method = 'PATCH';
                action = '{{ route('ajax-purchases.index') }}' +'/' + $('#id').val();
                console.log(method);
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
                    var errors = data.responseJSON.errors;
                    var firstItem = Object.keys(errors)[0];
                    var firstItemErrorMsg = errors[firstItem][0];
                    console.log(firstItem);
                    //Set Error Messages:
                    $('#form-errors').html('<strong>Attention!!!</strong> ' + firstItemErrorMsg);
                    $('#form-errors').show();
                    //Change button text.
                    $('#saveBtn').html('Save');
                }
            }); // Ajax call
            console.log(action);
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
                    size: 'small',
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
                    //centerVertical: true,
                    size: 'small',
                    closeButton: true,
                    message: "You are about to delete <strong>"+reference+"</strong>. Are you doing this by mistake? If you confirm records will be permantly deleted. <br>Please confirm your action.",
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