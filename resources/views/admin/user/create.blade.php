@extends('layouts.admin')
@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Create User</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<h1>Hi!! you can register users here.</h1><hr>
<div class="card card-register mx-auto mt-5 mb-3">
    <div class="card-header">Register new User</div>
    <div class="card-body">
        <form method="POST" action="{{route('users.store')}}" accept-charset="UTF-8">
            @csrf
            <!--Accordion for customer form-->
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
                                <div class="form-label-group">
                                    <input 
                                        type="text" 
                                        name="name" 
                                        id="name" 
                                        class="form-control" 
                                        placeholder="Customer name" 
                                        autofocus="autofocus" 
                                        value="{{old('name')}}">
                                    <label for="name">User name...</label>
                                </div>
                            </div>
                            <!--email input-->
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input 
                                        type="text" 
                                        name="email" 
                                        id="email" 
                                        class="form-control" 
                                        placeholder="Email address"
                                        value="{{old('email')}}"
                                        >
                                    <label for="email">Email address...</label>
                                </div>
                            </div>
                            <!--Role picker-->
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <select class="form-control" name="role" id="role">
                                            <option selected="selected" value="">User Role...</option>
                                            @foreach($roles as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--File upload input-->
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="file" name="image" id="image" class="form-control-file">
                                    <label for="image">Upload photo (optional)</label>
                                </div>
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
                                            @foreach ($address_labels as $key => $value)
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
                            <!--organization input-->
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input 
                                        type="text" 
                                        name="organization" 
                                        id="organization" 
                                        class="form-control"
                                        placeholder="organization" 
                                        value="{{old('organization')}}">
                                    <label for="organization">Organization or Company name...</label>
                                </div>
                            </div>
                            <!--address input-->
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input 
                                        type="text" 
                                        name="address" 
                                        id="address" 
                                        class="form-control"
                                        placeholder="address" 
                                        value="{{old('address')}}">
                                    <label for="address">Full Address...</label>
                                </div>
                            </div>
                            <!--state/city input-->
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input 
                                                type="text" 
                                                name="state" 
                                                id="state" 
                                                class="form-control"
                                                placeholder="state" 
                                                value="{{old('state')}}">
                                            <label for="state">State...</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input 
                                                type="text" 
                                                name="city" 
                                                id="city" 
                                                class="form-control"
                                                placeholder="city" 
                                                value="{{old('city')}}">
                                            <label for="city">City...</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--postal_code/area input-->
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input 
                                                type="text" 
                                                name="postal_code" 
                                                id="postal_code" 
                                                class="form-control"
                                                placeholder="postal_code" 
                                                value="{{old('postal_code')}}">
                                            <label for="postal_code">Postal code...</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input 
                                                type="text" 
                                                name="area" 
                                                id="area" 
                                                class="form-control"
                                                placeholder="area" 
                                                value="{{old('area')}}">
                                            <label for="area">Area (Optional)...</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--latitude/longitude input-->
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input 
                                                type="text" 
                                                name="latitude" 
                                                id="latitude" 
                                                class="form-control"
                                                placeholder="latitude" 
                                                value="{{old('latitude')}}">
                                            <label for="latitude">Latitude...</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input 
                                                type="text" 
                                                name="longitude" 
                                                id="longitude" 
                                                class="form-control"
                                                placeholder="longitude" 
                                                value="{{old('longitude')}}">
                                            <label for="longitude">Longitude...</label>
                                        </div>
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
<!--                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <button id="addAddressBtn" type="button" class="btn btn-success btn-sm form-control">Add</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button id="remAddressBtn" type="button" class="btn btn-warning btn-sm form-control">Del</button>
                                    </div>
                                </div>
                            </div>-->

                        </div> <!--./card-body -->
                    </div> <!--./collapse-->
                </div> 
                <!--Card of Password Fields-->
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Password:
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <!-- Contact input group -->
                            <div class="form-group">
                                <div class="form-row pb-3">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">
                                            <label for="inputPassword">User's Password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm password">
                                            <label for="confirmPassword">Confirm password</label>
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
                                        <select class="form-control" name="contact_label[]" id="contact_label0">
                                            <option selected="selected" value="">Contact Label...</option>
                                            @foreach($contact_labels as $key => $value)
                                            <option value="{{$value}}">{{ ucfirst($value) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <div class="form-label-group">
                                            <input 
                                                type="text" 
                                                name="country_code_contact[]" 
                                                id="country_code_contact0" 
                                                class="form-control"
                                                placeholder="country_code_contact" 
                                            <label for="country_code_contact0">Co Code</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-label-group">
                                            <input 
                                                type="text" 
                                                name="city_code_contact[]" 
                                                id="city_code_contact0" 
                                                class="form-control"
                                                placeholder="city_code_contact" 
                                            <label for="city_code_contact0">City Code</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-label-group">
                                            <input 
                                                type="text" 
                                                name="number[]" 
                                                id="number0" 
                                                class="form-control"
                                                placeholder="number" 
                                            <label for="number0">Phone number...</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="remContactBtn" class="btn btn-warning btn-sm mt-2">Del</a>
                                    </div>
                                </div>
                            </div>
                            <button id="addContactBtn" type="button" class="btn btn-success btn-sm mt-2">Add</button>
                        </div> <!--./card-body-->
                    </div> <!--./collapse-->
                </div> 
            </div> <!-- #/accordionExample -->
            <div class="form-row">
                <div class="col-md-6">
                    <input class="btn btn-primary btn-block mb-3" type="submit" value="Register">
                </div>
                <div class="col-md-6">
                    <a class="btn btn-success form-control" href="{{route('users.index')}}">Back</a>
                </div>
            </div>
            
        </form>
        @include('includes.display_form_errors')
    </div>
</div>

<script>
    /*
     * Check password match
     */
    var password = document.getElementById("inputPassword"), confirm_password = document.getElementById("confirmPassword");

    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
    }
    password.onchange = validatePassword();
    confirm_password.onkeyup = validatePassword();
    
    /*
     * Clear customer details view area:
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
        $('#organization').val('');
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
        * addAddressBtn click:
        * To add new address.
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
                                   '<select class="form-control" name="contact_label[]" id="contact_label'+count+'">'+
                                       '<option selected="selected" value="">Contact Label...</option>'+
                                       '@foreach($contact_labels as $key => $value)'+
                                       '<option value="{{$value}}">{{ ucfirst($value) }}</option>'+
                                       '@endforeach'+
                                   '</select>'+
                               '</div>'+
                           '</div>'+
                           '<div class="form-row">'+
                               '<div class="col-md-3">'+
                                   '<div class="form-label-group">'+
                                       '<input type="text" name="country_code_contact[]" class="form-control" placeholder="country_code_contact" id="country_code_contact'+count+'">'+ 
                                       '<label for="country_code_contact'+count+'">Co Code</label>'+
                                   '</div>'+
                               '</div>'+
                               '<div class="col-md-3">'+
                                   '<div class="form-label-group">'+
                                       '<input type="text" name="city_code_contact[]" class="form-control" placeholder="city_code_contact" id="city_code_contact'+count+'">'+
                                       '<label for="city_code_contact'+count+'">City Code</label>'+
                                   '</div>'+
                               '</div>'+
                               '<div class="col-md-5">'+
                                   '<div class="form-label-group">'+
                                       '<input type="text" name="number[]" class="form-control" placeholder="number" id="number'+count+'">'+
                                       '<label for="number'+count+'">Phone number...</label>'+
                                   '</div>'+
                               '</div>'+
                               '<div class="col-md-1">'+
                                   '<a href="remContactBtn" class="btn btn-warning btn-sm mt-2">Del</a>'+
                               '</div>'+
                           '</div>'+
                       '</div>';
               $(this).before(html);
       });
       
       /*
        * remContactBtn (Del) anchor click:
        * Remove one contact field:
        */
       $('#collapseFour').on('click', 'a', function(e){
           e.preventDefault();
           var value = $(this).attr('href');
           value == 'remContactBtn' ? $(this).closest('.form-group').remove() : '' ;
       });
       
       /*
        * Scroll to bottom if error msg:
        */
       //console.log($('.alert ol').length);
       if($('.alert ol').length > 0){
           window.scrollTo(0,document.body.scrollHeight);
       }
        
    });
    
    
    
    
</script>
@stop