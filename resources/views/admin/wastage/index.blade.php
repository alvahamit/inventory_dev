<!-- 
    Author:     Alvah Amit Halder
    Document:   Wastage Index blade.
    Model/Data: App\Wastage
    Controller: WastageController
-->

@extends('theme.default')

@section('title', __('VSF-Wastage'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Records of Wastage'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')


<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">Wastage</li>
</ol>

<!--<h1>Hi!! you have following orders:</h1>-->
<!--Add new button-->
<div class="form-group text-right d-print-none">
    <button id="createNew" class="btn btn-primary right">New Record</button>
</div> 
<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Wastage Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reference</th>
                        <th>Date</th>
                        <th>Wasted at</th>
                        <th>Store</th>
                        <th>Issued By</th>
                        <th>Report</th>
                        <th>Is Approved?</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Reference</th>
                        <th>Date</th>
                        <th>Wasted at</th>
                        <th>Store</th>
                        <th>Issued By</th>
                        <th>Report</th>
                        <th>Is Approved?</th>
                        <th>Action</th>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated {{$lastUpdated}}</div>
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
                <form id="wastageForm" name="wastageForm" class="form-horizontal" autocomplete="off">
                    <div id="form-errors" class="alert alert-warning alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                    @csrf
                    <!--hidden id input-->
                    <input type="hidden" name="id" id="id">
                    
                    <!-- form-group -->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="wastage_no">Ref No:</label>
                                <input type="text" name="wastage_no" id="wastage_no" class="form-control" autofocus="autofocus" value="{{old('wastage_no')}}">
                            </div>
                            <div class="col-md-6">
                                <label for="wastage_date">Date:</label>
                                <input type="date" name="wastage_date" id="wastage_date" class="form-control" value="{{old('wastage_date')}}">
                            </div>
                        </div>
                    </div>
                    <!-- ./form-group -->
                    
                    <!-- form-group -->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="wasted_at">Wasted at:</label>
                                <select class="custom-select" name="wasted_at" id="wasted_at">
                                    <!--<option value="0" selected>Select where...</option>-->
                                    @foreach(config('constants.wasted_at') as $key => $value)
                                    <option value="{{ $value }}"> {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="store_id">Select Intended Store Space:</label>
                                <select class="custom-select" name="store_id" id="store_id">
                                    <option value="" selected>Select store...</option>
                                    @foreach($stores as $store)
                                    <option value="{{ $store->id }}"> {{ $store->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="store_name" id="store_name">
                            </div>
                        </div>
                    </div>
                    <!-- ./form-group -->
                    
                    
                    
                    <!--Accordion-->
                    <div class="accordion pb-3" id="accordionExample">
                        <!--Card of Wastage Items-->
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        Wasted Items:
                                    </button>
                                </h2>
                            </div> <!--#/headingTwo--> 
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="form-group"> <!-- form-group -->
                                        <!--Unit chooser-->
                                        <div class="container">
                                            <div class="form-row pb-3">
                                            <label class="col-form-label col-form-label-sm" for="quantity_type">Quantity Type: </label>
                                            <select id="quantity_type" name="quantity_type" class="custom-select custom-select-sm col-md-3">
                                                @foreach(config('constants.quantity_type') as $key => $value)
                                                <option value="{{ $key }}"> {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        </div>
                                        
                                        <div class="form-row">
                                            <div class="table-responsive">
                                                <table class="table" id="items">
                                                    <thead>
                                                        <tr>
                                                            <th>Item Name</th>
                                                            <th style="width: 15%">Quantity</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>
                                            </div> <!-- ./table-responsive -->
                                            <button name="add-row" id="add-row" class="btn btn-sm btn-success float-left"><i class="fas fa-plus"></i> Add Row</button>
                                        </div> <!-- ./form-row -->
                                    </div> <!-- ./form-group -->
                                    
                                </div> <!--./card-body-->
                            </div> <!--#/collapseTwo--> 
                        </div> <!--./card--> 
                        
                        <!--Card of Report-->
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Brief Report on Wastage:
                                    </button>
                                </h2>
                            </div> <!--#/headingOne--> 
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="container">
                                        <!-- form-group -->
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="pt-1">
                                                        <label for="report">Report:</label>
                                                        <textarea type="text" name="report" id="report" class="form-control" rows="6">{!! old('report') !!}</textarea>
                                                    </div>
                                                </div>  <!-- ./col-md-12 -->
                                            </div> <!-- ./form-row -->
                                        </div> <!-- ./form-group -->
                                        <!--is_approved-->
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label for="is_approved" class="col-form-label text-md-right">{{ __('Is Approved?') }}</label>
                                                    <div class="offset-md-1 col-md-6 form-check form-check-inline">
                                                        @if($hasPowerRole)
                                                        <input type="radio" class="col-md-3" id="yes" name="is_approved" value="{{ old('is_approved', 1) }}">
                                                        @else
                                                        <input type="radio" class="col-md-3" id="yes" name="is_approved" value="{{ old('is_approved', 1) }}" disabled="disabled">
                                                        @endif
                                                        <label for="yes" class="form-check-label">Yes</label>
                                                        @if($hasPowerRole)
                                                        <input type="radio" class="col-md-3" id="no" name="is_approved" value="{{ old('is_approved', 0) }}">
                                                        @else
                                                        <input type="radio" class="col-md-3" id="no" name="is_approved" value="{{ old('is_approved', 0) }}" disabled="disabled">
                                                        @endif
                                                        <label for="no" class="form-check-label">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--For Update Only-->
                                        <div id="update-extra" class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="issued_by">Issued by:</label>
                                                    <input type="text" name="issued_by" id="issued_by" class="form-control" value="{{old('issued_by')}}" readonly="readonly">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="approved_by">Approved by:</label>
                                                    <input type="text" name="approved_by" id="approved_by" class="form-control" value="{{old('approved_by')}}" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div> <!--./container-->                    
                                </div> <!--./card-body-->
                            </div> <!--#/collapseOne-->
                        </div> <!--./card--> 
                    </div> <!-- /#accordionExample -->
                    <!--End of Accordion-->
                    <!--Form buttons-->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4 offset-md-2">
                                <button name="saveBtn" id="saveBtn" type="submit" class="btn btn-primary form-control">Save</button>
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
        max-width: 50%; 
        width: 50% !important; 
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
 * Reset Modal:
 * Close (modal) function:
 */
function closeModal(){
    $('#form-errors').hide();
    $('#saveBtn').html('Save');
    $('#wastageForm').trigger("reset");
    $('#items .set').remove();
    $('#id').val('');
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
            url: "{{ route('wastage.index') }}",
        },
        columns: [
            {data:'DT_RowIndex', name:'DT_RowIndex'},
            {data: 'wastage_no', name: 'wastage_no'},
            {data: 'wastage_date', name: 'wastage_date'},
            {data: 'wasted_at', name: 'wasted_at'},
            {data: 'store_name', name: 'store_name'},
            {data: 'issued_by', name: 'issued_by'},
            {data: 'report', name: 'report'},
            {data: 'is_approved', name: 'is_approved'},
            {data: 'action', name: 'action'},
        ],
        order:[[1, "desc"]],
        columnDefs: [
            {
                "targets": 7, // Count starts from 0.
                "className": "text-center",
                "width": "auto"
            },
            {
                "targets": 8, // Count starts from 0.
                "className": "text-center",
                "width": "auto"
            },
        ],
    });
  
  
    /*
     * Initialize product options.
     */
    getProductsByQuantityType();
  
    /*
     * Create new:
     * Show/View Modal Form.
     */
    $('#createNew').click(function () {
        $('#update-extra').hide();
        $('#closeBtn').html("Close");
        $('#closeBtn').val("close-modal");
        $('#saveBtn').val("create-order");
        $('#id').val('');
        $('#form-errors').hide();
        $('#wastageForm').trigger("reset");
        $('#modelHeading').html("Report Wastage");
        $.get("{{ route('get.wastage.ref') }}", function (data) {
            $('#wastage_no').val(data);
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
        $('#wastage_no').trigger('focus');
    }); //Create New - Click function.

    /*
     * When modal is hidden
     * Change 
     */
    $('#ajaxModel').on("hidden.bs.modal", function () {
        closeModal();
    });


    /*
     * Ajax Call goes to: PurchaseController@getProdData
     * This call gets product data for adding 
     * item rows.
     */
    var productOptions; //This value is set by ajax call. 
    function getProductsByQuantityType(quantity_type = ""){
        $.ajax({
            url: "{{ route('ajax-order.get.product.options') }}",
            type: "GET",
            data:{  'quantity_type': quantity_type },
            cache: false,
            dataType: 'json',
            success: function(response){
                //console.log(response);
                productOptions = response.items;
                return productOptions;
            },
            error: function(response){
                console.log(response);
            }
        });
    }
    
    function getProductOptions(qType){
        $('#items .set').remove();
        getProductsByQuantityType(qType);
    }

    $('#quantity_type').change(function(){
        getProductOptions($('#quantity_type').val());
    });
    
    $('#store_id').change(function(){
        var storeName = $('#store_id option:selected').text();
        $('#store_name').val(storeName);
        //console.log(storeName);
    });
    
    /*
     * Modal "Add Row" click function:
     * Adding Dynamic Rows
     */
    $("#add-row").click(function(e){
        e.preventDefault();
        //$("#summery").show();
        var row_count = $('#items tr').length - 1;
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
                '<td><button id="remove' + row_no + '" type="button" class="close" data-dismiss="alert">&times;</button></td>' +
                '</tr>';
        $('#items tbody').append(html);
        
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
            action = '{{ route("wastage.store") }}';
            //Ajax call to save data:
            $.ajax({
                data: $('#wastageForm').serialize(),
                url: action,
                type: method,
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    $('#saveBtn').html('Save');
                    closeModal();
                    //Page message:
                    $('#pageMsg').html(showMsg(data.status, data.message));
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
                    $("#ajaxModel .modal-body").animate({ scrollTop: 0 }, 1000);
                }
            }); // Ajax call
        };
        if (actionType == 'update'){
            method = 'PATCH';
            action = '{{ route("wastage.index") }}' + '/' + $('#id').val();
            // Confirm box
            bootbox.dialog({
                backdrop: true,
                centerVertical: false,
                size: 'medium',
                closeButton: false,
                message: "{!! config('constants.messages.update_alert') !!}",
                title: "Please confirm...",
                buttons: {
                  success: {
                    label: "Confirm",
                    className: "btn-danger",
                    callback: function() {
                        $.ajax({
                            data: $('#wastageForm').serialize(),
                            url: action,
                            type: method,
                            dataType: 'json',
                            success: function (data) {
                                //console.log('Success:', data);
                                $('#wastageForm').trigger("reset");
                                $('#saveBtn').html('Save');
                                $('#ajaxModel').modal('hide');
                                $('#dataTable').DataTable().ajax.reload();
                                //Page message:
                                $('#pageMsg').html(showMsg(data.status, data.message));
                                $("html, body").animate({ scrollTop: 0 }, 1000);
                                closeModal();
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
                        console.log(action);
                    }
                  },
                  danger: {
                    label: "Cancel",
                    className: "btn-success",
                    callback: function() {
                        $('#wastageForm').trigger("reset");
                        $('#closeBtn').html('Delete');
                        closeModal();
                    }
                  }
                }
            });
        };
        
        
               
        
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
                centerVertical: false,
                size: 'medium',
                closeButton: false,
                message: "{!! config('constants.messages.delete_alert') !!}",
                title: "Please confirm...",
                buttons: {
                  success: {
                    label: "Confirm",
                    className: "btn-danger",
                    callback: function() {
                        var id = $('#id').val();
                        var action = '{{ route("wastage.index") }}/' + id;
                        var method = 'DELETE';
                        $.ajax({
                            data: {"_token": "{{ csrf_token() }}"},
                            url: action,
                            type: method,
                            dataType: 'json',
                            success: function (data) {
                                //console.log('Success:', data);
                                $('#wastageForm').trigger("reset");
                                $('#closeBtn').html('Delete');
                                $('#ajaxModel').modal('hide');
                                $('#dataTable').DataTable().ajax.reload();
                                //Page message:
                                $('#pageMsg').html(showMsg(data.status, data.message));
                                $("html, body").animate({ scrollTop: 0 }, 1000);
                                closeModal();
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
                        $('#wastageForm').trigger("reset");
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
    * Actions.
    */
    $('#dataTable').on('click', 'a.edit', function (e) {
        e.preventDefault();
        var id = $(this).attr('href');
        //console.log(id);
        var action = '{{ route("wastage.index") }}' + '/' + id + '/edit';
        var method = 'GET';
        $.ajax({
            //data: { "id": id },
            url: action,
            type: method,
            dataType: 'json',
            success: function(data) { 
                //console.log(data);
                $('#id').val(data[0]['id']);
                $('#wastage_no').val(data[0]['wastage_no']);
                $('#wastage_date').val(data[0]['wastage_date']);
                $('#wasted_at').val(data[0]['wasted_at']).attr('selected','selected');
                $('#store_id').val(data[0]['store_id']).attr('selected','selected');
                $('#store_name').val(data[0]['store_name']);
                //Setup quantiy and options:
                $('#quantity_type').val(data[0]['quantity_type']).attr('selected','selected');
                $('#issued_by').val(data[0]['issued_by']);
                if(data[0]['is_approved']){
                    $('#yes').attr('checked','checked');
                } else {
                    $('#no').attr('checked','checked');
                }
                $('#report').val(data[0]['report']);
                $('#approved_by').val(data[0]['approved_by']);
                //Get ordered products:
                $.ajax({
                    url: "{{ route('ajax-order.get.product.options') }}",
                    type: "GET",
                    data:{  'quantity_type': data[0]['quantity_type'] },
                    cache: false,
                    dataType: 'json',
                    success: function(response){
                        productOptions = response.items;
                        var options;
                        $(data[0]['stock']).each(function(index, value){
                        //$(data.order.products).each(function(index, value){
                            //console.log(value.id);
                            var row_count = $('#items tr').length - 1;
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
                                '<td><input type="number" min="0" id="qty' + row_no + '" name="quantities[]" class="form-control form-control-sm qty" value="'+ value.pivot.formated_qty +'"/></td>' +
                                '<td><button id="remove' + row_no + '" type="button" class="close" data-dismiss="alert">&times;</button></td>' +
                                '</tr>';
                            $('#items tbody').append(html);
                            $('.close').click(function(e){
                                e.preventDefault();
                                var el_id = event.target.id;
                                var row_no = el_id.substr(6, );
                                var trID = 'set' + row_no;
                                $('#' + trID).remove();
                                $('.item_total').trigger('change');
                                //console.log($('#items tr').length);
                            });

                        })
                    },
                    error: function(response){
                        console.log(response);
                    },
                });
            },
            error: function(data) { 
                console.log(data); 
            }
        });
        $('#update-extra').show();
        $('#closeBtn').html("Delete");
        $('#closeBtn').val("delete");
        $('#saveBtn').val("update");
        //$('#id').val('');
        $('#form-errors').hide();
        $('#wastageForm').trigger("reset");
        $('#modelHeading').html("Update Wastage Report");
        //Setup modal option:
        $('#ajaxModel').modal({
            backdrop: 'static',
            keyboard: false,
            closeButton: true,
        });
        $('#closeBtn').show();
        $('#ajaxModel').modal('show');
        $('#ajaxModel').modal('handleUpdate');
        $('#wastage_no').trigger('focus');
    });
    $('#dataTable').on('click', 'a.del', function (e){
        e.preventDefault();
        var id = $(this).attr('href');
        // Confirm box
        bootbox.dialog({
            backdrop: true,
            centerVertical: false,
            size: '50%',
            closeButton: false,
            message: "{!! config('constants.messages.delete_alert') !!}",
            title: "Please confirm...",
            buttons: {
              success: {
                label: "Confirm",
                className: "btn-danger",
                callback: function() {
                    var action = '{{ route("wastage.index") }}/'+id;
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
                            $("html, body").animate({ scrollTop: 0 }, 1000);
                        },
                        error: function (data) {
                            console.log(data);
                            $('#pageMsg').html(showMsg(false, 'Something is not right!!!'));
                            $("html, body").animate({ scrollTop: 0 }, 1000);
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