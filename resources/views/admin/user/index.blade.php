<!-- 
    Author:     Alvah Amit Halder
    Document:   Users's Index blade.
    Model/Data: App\User
    Controller: UsersController
-->

@extends('theme.default')

@section('title', __('VSF-Users'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('List of Categories'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Users</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<!--<h3>Hi!! I found following users for you:</h3>-->
<!--Add new button-->
<div class="form-group text-right d-print-none">
    <!--<a class="btn btn-primary right" href="{{route('users.create')}}">Add new</a>-->
    <button id="newBtn" class="btn btn-primary right">New User</button>
</div> 
<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Users Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Active?</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Active?</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated {{$lastUpdated ?? ""}}</div>
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
                    <!--Edit Form-->
                    <form id="modalForm" name="modalForm" class="form-horizontal" style="display:none" accept-charset="UTF-8">
                        @csrf
                        <div id="form-errors" class="alert alert-warning" style="display: none"></div>
                        <!--hidden id input-->
                        <input type="hidden" name="user_id" id="user_id">
                        <!--Accordion for user form-->
                        <div class="accordion pb-3" id="accordionExample">
                            <!--Card of General Information-->
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            User Information:
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <!--name input-->
                                        <div class="form-group">
                                            <label for="name">Full Name:</label>
                                            <input type="text" name="name" id="name" class="form-control" autofocus="autofocus" value="{{old('name')}}">
                                        </div>
                                        <!--organization input-->
                                        <div class="form-group">
                                            <label for="organization">Company Name:</label>
                                            <input type="text" name="organization" id="organization" class="form-control" value="{{old('organization')}}">
                                        </div>
                                        <!--email input-->
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="text" name="email" id="email" class="form-control" value="{{old('email')}}">
                                        </div>
                                        <!--Role picker-->
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="role">User Role:</label>
                                                    <!--<select class="form-control" name="role" id="role">-->
                                                    <select id="role" name="roles[]" class="selectpicker form-control" multiple title="Select roles..." data-selected-text-format="count" data-style="btn-success" data-actions-box="true">
                                                        <!--<option value="">Select role...</option>-->
                                                        @foreach($roles as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!--is_active-->
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label for="is_active" class="col-form-label text-md-right">{{ __('Is Active?') }}</label>
                                                    <div class="offset-md-1 col-md-6 form-check form-check-inline">
                                                        <input type="radio" class="col-md-3" id="yes" name="is_active" value="{{ old('is_active', 1) }}">
                                                        <label for="yes" class="form-check-label">Yes</label>
                                                        <input type="radio" class="col-md-3" id="no" name="is_active" value="{{ old('is_active', 0) }}">
                                                        <label for="no" class="form-check-label">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--File upload input-->
                                        <div class="form-group">
                                            <label for="image">Upload photo (optional)</label>
                                            <input type="file" name="image" id="image" class="form-control-file">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <!--Card of Address Fields-->
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Address Information:
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <!--address type picker-->
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <!--hidden id input-->
                                                    <input type="hidden" name="address_id" id="address_id">
                                                    <label>Address Label: </label>
                                                    <select class="form-control" name="address_label" id="address_label">
                                                        <option selected="selected" value="">Pick a label...</option>
                                                        @foreach (config("constants.labels") as $key => $value)
                                                        <option value="{{ $value }}">{{ ucfirst($value) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Address to be used for: -->
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="form-check form-check-inline">
                                                        <input id="is_primary" name="is_primary" class="form-check-input" type="checkbox">
                                                        <label class="form-check-label">Primary</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input id="is_billing" name="is_billing" class="form-check-input" type="checkbox">
                                                        <label class="form-check-label">Billing</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input id="is_shipping" name="is_shipping" class="form-check-input" type="checkbox">
                                                        <label class="form-check-label">Shipping</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!--address input-->
                                        <div class="form-group">
                                            <label for="address">Full Address:</label>
                                            <textarea rows="3" class="form-control" name="address" id="address" value="{{old('address')}}"></textarea>
                                        </div>
                                        <!--state/city input-->
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="state">State:</label>
                                                    <input type="text" name="state" id="state" class="form-control" value="{{old('state')}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="city">City:</label>
                                                    <input type="text" name="city" id="city" class="form-control" value="{{old('city')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <!--postal_code/area input-->
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="postal_code">Post Code:</label>
                                                    <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{old('postal_code')}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="area">Area (Optional)...</label>
                                                    <input type="text" name="area" id="area" class="form-control" value="{{old('area')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <!--latitude/longitude input-->
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="latitude">Latitude:</label>
                                                    <input type="text" name="latitude" id="latitude" class="form-control" value="{{old('latitude')}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="longitude">Longitude:</label>
                                                    <input type="text" name="longitude" id="longitude" class="form-control" value="{{old('longitude')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <!--Country picker-->
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label>Country: </label>
                                                    <select class="form-control" name="country_code" id="country_code">
                                                        <option selected="selected" value="">Select Country...</option>
                                                        @foreach($countries as $country)
                                                        <option value="{{$country->code}}">{{$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <button id="addAddressBtn" type="button" class="btn btn-success btn-sm form-control">Add Address</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <button id="remAddressBtn" type="button" class="btn btn-warning btn-sm form-control">Del Address</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!--./card-body -->
                                </div> <!--./collapse-->
                            </div> 
                            <!--Card of Password Fields-->
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Username &#38; Password:
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <!--name input-->
                                        <div class="form-group">
                                            <label for="username">Username:</label>
                                            <input type="text" name="username" id="username" class="form-control" value="{{old('username')}}">
                                        </div>
                                        <!-- Password input group -->
                                        <div class="form-group">
                                            <div class="form-row pb-3">
                                                <div class="col-md-12">
                                                    <div class="form-label-group">
                                                        <label for="inputPassword">Password:</label>
                                                        <input type="password" name="password" id="inputPassword" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="form-label-group">
                                                        <label for="confirmPassword">Confirm Password:</label>
                                                        <input type="password" name="password_confirmation" id="confirmPassword" class="form-control" >
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!--./card-body-->
                                </div> <!--./collapse-->
                            </div> 
                            <!--Card of Contact Fields-->
                            <div class="card">
                                <div class="card-header" id="headingFour">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            Contact Information:
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <!-- Contact input group -->
                                        <div class="form-group pb-3">
                                            <div class="form-row pb-3">
                                                <div class="col-md-12">
                                                    <!--hidden id input-->
                                                    <input type="hidden" name="contact_ids[]" id="contact_id0">
                                                    <label for="contact_label0">Contact Label:</label>
                                                    <select class="form-control" name="contact_label[]" id="contact_label0">
                                                        <option selected="selected" value="">Select label...</option>
                                                        @foreach(config("constants.labels") as $key => $value)
                                                        <option value="{{$value}}">{{ ucfirst($value) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-3">
                                                    <label for="country_code_contact0">Country Code:</label>
                                                    <input type="text" name="country_code_contact[]" id="country_code_contact0" class="form-control">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="city_code_contact0">City Code:</label>
                                                    <input type="text" name="city_code_contact[]" id="city_code_contact0" class="form-control"> 
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="number0">Phone Number:</label>
                                                    <input type="text" name="number[]" id="number0" class="form-control">
                                                </div>
                                                <div class="col-md-1">
                                                    <label></label>
                                                    <a href="remContactBtn" class="btn btn-warning btn-sm mt-2">Del</a>
                                                </div>
                                            </div>
                                        </div>
                                        <button id="addContactBtn" type="button" class="btn btn-success btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
                                    </div> <!--./card-body-->
                                </div> <!--./collapse-->
                            </div> 
                        </div> <!-- #/accordionExample -->
                        <!--Save and Delete buttons-->
                        <div class="form-group pt-3">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary form-control" id="saveBtn" value="create">Save</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-danger form-control" id="deleteBtn" value="delete">Delete</button>
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
        max-width: 40%; 
        width: 40% !important; 
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
<!--End of Modal-->

@stop

@section('scripts')
<!--Script for this page-->
<script type="text/javascript">
    /*
     * Clear user details view area:
     * Clears first/show part of modal.
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
        $('#address').val('');
        $('#state').val('');
        $('#city').val('');
        $('#postal_code').val('');
        $('#area').val('');
        $('#latitude').val('');
        $('#longitude').val('');
        $('#country_code').val('').attr('selected','selected');
    }
    
$(document).ready(function(){  
    /*
     * Initialize Yaira on document table:
     */
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('users.index') }}"
        },
        columns: [
            {data:'DT_RowIndex', name:'DT_RowIndex'},
            {data:'name', name:'name'},
            {data:'username', name:'username'},
            {data:'organization', name:'organization'},
            {data:'email', name:'email'},
            {data:'role', name:'role'},
            {data:'is_active', name:'is_active'},
            {data:'created_at', name:'created_at'},
            {data:'updated_at', name:'updated_at'},
            {data:'action', name:'action'},
        ],
        order:[[1,"asc"]],
        columnDefs: [
            {
                "targets": 6, // Count starts from 0.
                "className": "text-center",
                "width": "auto"
            },
            {
                "targets": 9, // Count starts from 0.
                "className": "text-center",
                "width": "auto"
            },
        ],
    });
    
    /*
     * ajaxModel hidden jQuery:
     * Clear all fields and reset form upon hide.
     */
    $('#ajaxModel').on('hidden.bs.modal', function (e) {
        clearViewFields();
        clearAddressFields();
        $('#form-errors').html('');
        $('#form-errors').hide();
        $('#saveBtn').html('Save');
        $('#saveBtn').val('');
        $('#modalForm a[href^="remContactBtn"]').each(function(){
            $(this).closest('.form-group').remove();
        });
        $('#modalForm').trigger("reset");
        $('#addContactBtn').trigger('click');
        $('#role').selectpicker("refresh");
    });
    
    /*
     * addAddressBtn click:
     * To add new address.
     * This method clears all address fields.
     */
    $('#addAddressBtn').click(function(e){
        e.preventDefault();
        clearAddressFields();
    });
    
    /*
     * addContactBtn click:
     * Add more contact fields.
     */
    $('#addContactBtn').click(function(e){
        e.preventDefault();
        var count = $(this).closest('.card-body').children().length - 1;
        var html = '<div class="form-group pb-3">'+
                        '<div class="form-row pb-3">'+
                            '<div class="col-md-12">'+
                                '<input type="hidden" name="contact_ids[]" id="contact_id'+count+'">'+
                                '<label for="contact_label0">Contact Label:</label>'+
                                '<select class="form-control" name="contact_label[]" id="contact_label'+count+'">'+
                                    '<option selected="selected" value="">Select Label...</option>'+
                                    '@foreach(config("constants.labels") as $key => $value)'+
                                    '<option value="{{$value}}">{{ ucfirst($value) }}</option>'+
                                    '@endforeach'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-row">'+
                            '<div class="col-md-3">'+
                                '<label for="country_code_contact'+count+'">Country Code:</label>'+
                                '<input type="text" name="country_code_contact[]" id="country_code_contact'+count+'" class="form-control">'+
                            '</div>'+
                            '<div class="col-md-3">'+
                                '<label for="city_code_contact'+count+'">City Code:</label>'+
                                '<input type="text" name="city_code_contact[]" id="city_code_contact'+count+'" class="form-control">'+
                            '</div>'+
                            '<div class="col-md-5">'+
                                '<label for="number'+count+'">Phone Number:</label>'+
                                '<input type="text" name="number[]" id="number'+count+'" class="form-control">'+
                            '</div>'+
                            '<div class="col-md-1">'+
                                '<a href="remContactBtn" class="btn form-control" style="margin-top:2rem;"><i class="fas fa-trash-alt"></i></a>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
            $(this).before(html);
    });
    
    /*
     * remContactBtn (Del) anchor click:
     * Remove one contact field:
     */
    $('#modalForm').on('click', 'a', function(e){
        e.preventDefault();
        var value = $(this).attr('href');
        value == 'remContactBtn' ? $(this).closest('.form-group').remove() : '' ;
    });
    
    /*
    * Remove Address button:
    * Goes to:
    * CustomersController@removeAddress
    */
    $('#remAddressBtn').click(function(){
        $('#remAddressBtn').html('Del..');
        // Confirm box
        bootbox.dialog({
            backdrop: true,
            //centerVertical: true,
            closeButton: false,
            message: "Are you doing this by mistake? <br> If you confirm a record will be permantly deleted. Please confirm your action.",
            title: "Please confirm...",
            buttons: {
              success: {
                label: "Confirm",
                className: "btn-danger",
                callback: function() {
                    var address_id = $('#address_id').val();
                    var user_id = $('#user_id').val();
                    $.ajax({
                        url: "{{ route('ajax-customer.remove.address') }}",
                        type: "DELETE",
                        data:{ 
                            '_token'    : '{{ csrf_token() }}', 
                            'address_id': address_id,
                            'user_id'   : user_id
                            },
                        cache: false,
                        dataType: 'json',
                        success: function(response){
                                //console.log(response);
                                $('#modalForm').trigger("reset");
                                $('#remAddressBtn').html('Del');
                                $('#ajaxModel').modal('hide');
                                $('#dataTable').DataTable().ajax.reload();
                            },
                        error: function(response){
                                console.log(response);
                            }
                    }); 
                }
              },
              danger: {
                label: "Cancel",
                className: "btn-success",
                callback: function() {
                    //$('#modalForm').trigger("reset");
                    //$('#remAddressBtn').html('Del');
                    //$('#ajaxModel').modal('hide');
                }
              }
            }
          });        
        
    });
    
    /*
     * Datatable Action column:
     */
    $('#dataTable').on('click', 'a.show', function (e) {
        var userId = $(this).attr('href');
        $.get('{{ route("users.index") }}' +'/' + userId, function (data) {
            //console.log(data);
            var addresses = data['user']['addresses'];
            var contacts = data['user']['contacts'];
            var roleName = '<ul>';
            var contactList;
            //find role name if set:
            if(data['user']['roles'].length>0){
                //roleName = data['user']['role'][0]['name'];
                $.each(data['user']['roles'], function(index,value){
                    //console.log(value['name']);
                    roleName += '<li>'+value['name']+'</li>';
                });
            } else {
                roleName += '<li>Undefined</li>';
            }
            roleName += '</ul>';
            //Clear previous data:
            clearViewFields(); 
            //Set new data:
            $('#user_id').val(data['user']['id']);
            $('#modelHeading').html(data['user']['name']+'<br><small class="text-muted">'+data['user']['organization']+'</small>');
            $('#displayEmail').html( 
                        '<div class="container">'+
                            '<span><i class="fas fa-user-tie"></i> Assigned Roles:'+
                            roleName+'</span><br>'+
                            '<span><i class="far fa-envelope"></i> '+
                            data['user']['email']+'</span>'+ 
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
                        '('+value.label+')<br>' 
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
                        +'<span class="float-left"><span><i class="fas fa-tag"></i> <strong>'+value.label+'</strong></span><br>'
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
                        +'<p>'+value.address+'<br>'
                        +value.state+', '
                        +value.city+'<br>'
                        +value.postal_code+'</p>'
                        +'<a id="editBtn" class="btn btn-primary col-3 float-right" href="'+ value.id +'">Edit</a>'
                        +'</div>'
                    );
                    //console.log(value.pivot.is_primary);
                });
            } else {
                $('#carouselInner').append(
                    '<div class="carousel-item">'
                    +'<p>No addresses found for this user.</p>'
                    +'<p>Please click "Edit" button below to edit or delete this user.</p>'
                    +'<a id="editBtn" class="btn btn-primary col-3 float-right" href="">Edit</a>'
                    +'</div>'
                );
            }
            //Set active classes for carousal to function properly:
            $('#carouselIndicators ol li').each(function(){
                $(this).attr('data-slide-to') == '0' ? $(this).attr('class','active') : '' ;
                //console.log($(this).attr('data-slide-to'));
            });
            $('#carouselInner div').first().addClass('active');
            //Finally show modal:
            $('#modalForm').hide();
            $('#carouselIndicators').show();
            $('#ajaxModel').modal('show');
            
        });
        //Stop following the link address:
        return false;
    }); //Action Show.
    $('#dataTable').on('click', 'a.edit', function (e) {
        var userId = $(this).attr('href');
        $.get('{{ route("users.index") }}' +'/' + userId, function (data) {
            //console.log(data);
            var addresses = data['user']['addresses'];
            var contacts = data['user']['contacts'];
            var roleName = '<ul>';
            var contactList;
            //find role name if set:
            if(data['user']['roles'].length>0){
                //roleName = data['user']['role'][0]['name'];
                $.each(data['user']['roles'], function(index,value){
                    //console.log(value['name']);
                    roleName += '<li>'+value['name']+'</li>';
                });
            } else {
                roleName += '<li>Undefined</li>';
            }
            roleName += '</ul>';
            //Clear previous data:
            clearViewFields(); 
            //Set new data:
            $('#user_id').val(data['user']['id']);
            $('#modelHeading').html(data['user']['name']+'<br><small class="text-muted">'+data['user']['organization']+'</small>');
            $('#displayEmail').html( 
                        '<div class="container">'+
                            '<span><i class="fas fa-user-tie"></i> Assigned Roles:'+
                            roleName+'</span><br>'+
                            '<span><i class="far fa-envelope"></i> '+
                            data['user']['email']+'</span>'+ 
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
                        '('+value.label+')<br>' 
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
                        +'<span class="float-left"><span><i class="fas fa-tag"></i> <strong>'+value.label+'</strong></span><br>'
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
                        +'<p>'+value.address+'<br>'
                        +value.state+', '
                        +value.city+'<br>'
                        +value.postal_code+'</p>'
                        +'<a id="editBtn" class="btn btn-primary col-3 float-right" href="'+ value.id +'">Edit</a>'
                        +'</div>'
                    );
                    //console.log(value.pivot.is_primary);
                });
            } else {
                $('#carouselInner').append(
                    '<div class="carousel-item">'
                    +'<p>No addresses found for this user.</p>'
                    +'<p>Please click "Edit" button below to edit or delete this user.</p>'
                    +'<a id="editBtn" class="btn btn-primary col-3 float-right" href="">Edit</a>'
                    +'</div>'
                );
            }
            //Set active classes for carousal to function properly:
            $('#carouselIndicators ol li').each(function(){
                $(this).attr('data-slide-to') == '0' ? $(this).attr('class','active') : '' ;
                //console.log($(this).attr('data-slide-to'));
            });
            $('#carouselInner div').first().addClass('active');
            //Finally show modal:
            $('#modalForm').hide();
            $('#carouselIndicators').show();
            $('#ajaxModel').modal('show');
            
        });
        //Stop following the link address:
        return false;
    }); //Action Edit.
    $('#dataTable').on('click', 'a.del', function (e) {
        e.preventDefault();
        bootbox.alert({
            size: "small",
            title: "Opps!!!",
            message: "This functionality is not written yet! <br> If you need this Cry out to your developer.",
            backdrop: true
        });
    }) //Action Delete.
    $('#dataTable').on('click', 'a.yes', function (e) {
        e.preventDefault();
        bootbox.alert({
            size: "small",
            title: "Opps!!!",
            message: "This functionality is not written yet! <br> If you need this Cry out to your developer.",
            backdrop: true
        });
    }); //Action Activate.
    $('#dataTable').on('click', 'a.no', function (e) {
        e.preventDefault();
        bootbox.alert({
            size: "small",
            title: "Opps!!!",
            message: "This functionality is not written yet! <br> If you need this Cry out to your developer.",
            backdrop: true
        });
    }); //Action Deactivate
    
    
    
    /*
     * Carousel Edit/Add anchor click:
     * Editing User with selected Address.
     * UsersController@show or
     * UsersController@edit 
     * (depends on which method is defined.
     * If both defined $.get() will not work.)
     */
    $('#carouselInner').on('click', 'a', function(e){
        e.preventDefault();
        //Setup modal:
        clearViewFields();
        $('#modelHeading').html('Updating User');
        $('#carouselIndicators').hide();
        $('#saveBtn').val('update');
        $('#deleteBtn').removeAttr("disabled");
        $('#addAddressBtn').removeAttr("disabled").show();
        $('#remAddressBtn').removeAttr("disabled").show();
        //Fill up form:
        var userId = $('#user_id').val();
        var addressId = $(this).attr('href');
        $.get('{{ route("users.index") }}' +'/' + userId, function (data) {
            var addresses = data['user']['addresses'];
            var contacts = data['user']['contacts'];
            $('#name').val(data['user']['name']);
            $('#username').val(data['user']['username']);
            $('#organization').val(data['user']['organization']);
            if(data['user']['email']){ $('#email').val(data['user']['email']) } ;
            if(data['user']['is_active']){ $("#yes").prop("checked", true); }
            if(!data['user']['is_active']){ $("#no").prop("checked", true); }
            //Populate selectpicker: 
            if(data['user']['roles'].length>0){
                var roles = [];
                $.each(data['user']['roles'], function(index,value){
                    roles.push(value['id']);                   
                });
                $('#role').selectpicker('val', roles);
            }
            if(addressId !== ""){ 
                //console.log(addressId); 
                var selectedAddress;
                
                $(addresses).each(function(index, value){
                    addresses[index]['id'] == addressId ? selectedAddress = addresses[index] : '' ;
                });
                //console.log(selectedAddress); 
                $('#address_id').val(selectedAddress['id']);
                if(selectedAddress['label']){
                    //$('#address_label').val(selectedAddress['label'].toLowerCase()).attr('selected','selected');
                    $('#address_label').val(selectedAddress['label']).attr('selected','selected');
                };
                selectedAddress['pivot']['is_primary'] ? $('#is_primary').attr('checked', 'checked') : $('#is_primary').removeAttr('checked') ;
                selectedAddress['pivot']['is_billing'] ? $('#is_billing').attr('checked', 'checked') : $('#is_billing').removeAttr('checked') ;
                selectedAddress['pivot']['is_shipping'] ? $('#is_shipping').attr('checked', 'checked') : $('#is_shipping').removeAttr('checked') ;
                
                $('#address').val(selectedAddress['address']);
                $('#state').val(selectedAddress['state']);
                $('#city').val(selectedAddress['city']);
                $('#postal_code').val(selectedAddress['postal_code']);
                $('#area').val(selectedAddress['area']);
                $('#latitude').val(selectedAddress['latitude']);
                $('#longitude').val(selectedAddress['longitude']);
                $('#country_code').val(selectedAddress['country_code']).attr('selected','selected');
                //console.log(selectedAddress['pivot']['is_primary']);
            } 
            
            if(contacts.length > 0 ){
                //remove all previous contacts:
                $('#modalForm a[href^="remContactBtn"]').each(function(){
                    $(this).closest('.form-group').remove();
                });
                $(contacts).each(function(index, value){
                    var count = index;
                    var html = '<div class="form-group pb-3">'+
                                    '<div class="form-row pb-3">'+
                                        '<div class="col-md-12">'+
                                            '<input value="'+value.id+'" type="hidden" name="contact_ids[]" id="contact_id'+count+'">'+
                                            '<label for="contact_label'+count+'">Contact Label:</label>'+
                                            '<select class="form-control" name="contact_label[]" id="contact_label'+count+'">'+
                                                '<option selected="selected" value="">Select label...</option>'+
                                                '@foreach(config("constants.labels") as $key => $value)'+
                                                '<option value="{{$value}}">{{ ucfirst($value) }}</option>'+
                                                '@endforeach'+
                                            '</select>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-row">'+
                                        '<div class="col-md-3">'+
                                            '<label for="country_code_contact'+count+'">Country Code:</label>'+
                                            '<input value="'+value.country_code+'" type="text" name="country_code_contact[]" class="form-control" id="country_code_contact'+count+'">'+ 
                                        '</div>'+
                                        '<div class="col-md-3">'+
                                            '<label for="city_code_contact'+count+'">City Code:</label>'+
                                            '<input value="'+value.city_code+'" type="text" name="city_code_contact[]" class="form-control" id="city_code_contact'+count+'">'+
                                        '</div>'+
                                        '<div class="col-md-5">'+
                                            '<label for="number'+count+'">Phone Number:</label>'+
                                            '<input value="'+value.number+'" type="text" name="number[]" class="form-control" id="number'+count+'">'+
                                        '</div>'+
                                        '<div class="col-md-1">'+
                                            '<a href="remContactBtn" class="btn form-control" style="margin-top:2rem;"><i class="fas fa-trash-alt"></i></a>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';

                        $('#addContactBtn').before(html);
                        $('#contact_label'+count).val(value.label).attr('selected','selected');
                });
            }
            $('#modalForm').show();
        }); //get data.
    }); //Address Edit/Add anchor click
    
    /*
     * newBtn click:
     * Open blank modalForm 
     * to add new customer and details.
     */
    $('#newBtn').click(function () {
        clearAddressFields();
        clearViewFields();
        $('#carouselIndicators').hide();
        $('#modalForm a[href^="remContactBtn"]').each(function(){
            $(this).closest('.form-group').remove();
        });
        $('#modalForm').trigger("reset").show();
        $('#deleteBtn').attr("disabled","disabled");
        $('#addAddressBtn').attr("disabled", "disabled").hide();
        $('#remAddressBtn').attr("disabled", "disabled").hide();
        $('#saveBtn').val("create");
        $('#user_id').val('');
        $('#modelHeading').html("Create New");
        $('#addContactBtn').trigger('click');
        $('#ajaxModel').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#ajaxModel').modal('show');
    });
    
    /*
     * Save Modal form data to DB:
     * UsersController@store
     * UsersController@update
     */
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
        var actionType = $(this).val();
        var mehtod;
        var action;
        if(actionType == 'create'){ 
            method = 'POST';
            action = '{{ route('users.store') }}';
        };
        if(actionType == 'update'){ 
            method = 'PATCH';
            action = '{{ route("users.index") }}' +'/' + $('#user_id').val();
        };
        $.ajax({
            data: $('#modalForm').serialize(),
            url: action,
            type: method,
            dataType: 'json',
            success: function (data) {
                //console.log('Success:', data);
                $('#modalForm').trigger("reset");
                $('#saveBtn').html('Save');
                $('#ajaxModel').modal('hide');
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
                $('#ajaxModel').scrollTop(0);
                //Change button text.
                $('#saveBtn').html('Save');
            }
        }); // Ajax call
    }); // #saveBtn click function.
    
    /*
    * Delete button press funciton:
    * Delete User and detach contact, addresss.
    * Goes to: UsersController@destroy
    */
    $('#deleteBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Deleting...'); 
        // Confirm box
        bootbox.dialog({
            backdrop: true,
            //centerVertical: true,
            closeButton: false,
            message: "Are you doing this by mistake? <br> If you confirm a record will be permantly deleted. Please confirm your action.",
            title: "Please confirm...",
            buttons: {
              success: {
                label: "Confirm",
                className: "btn-danger",
                callback: function() {
                    //I DONT KNOW WHAT TO DO HERE
                    var userId = $('#user_id').val();
                    var action = '{{ route("users.index") }}'+'/' + userId;
                    var method = 'DELETE';
                    $.ajax({
                        data: $('#modalForm').serialize(),
                        url: action,
                        type: method,
                        dataType: 'json',
                        success: function (data) {
                            //console.log('Success:', data);
                            $('#modalForm').trigger("reset");
                            $('#deleteBtn').html('Delete');
                            $('#ajaxModel').modal('hide');
                            $('#dataTable').DataTable().ajax.reload();
                        },
                        error: function (data) {
                            //Change button text.
                            $('#deleteBtn').html('Delete');
                        }
                    }); // Ajax call
                    //console.log(action);
                    $('#modalForm').trigger("reset");
                    $('#deleteBtn').html('Delete');
                    $('#ajaxModel').modal('hide');
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
          });
    }); //Delete button press.
    
});
</script>

@stop