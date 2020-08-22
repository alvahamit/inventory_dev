<!-- 
    Author:     Alvah Amit Halder
    Document:   Profile blade for logged user.
    Model/Data: App\User
    Controller: UsersController
-->

@extends('theme.default')

@section('title', __('VSF-User Profile'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('User Profile'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Users</a>
    </li>
    <li class="breadcrumb-item active">Profile</li>
</ol>

<form id="profileForm" name="profileForm" class="form-horizontal" style="display:none" accept-charset="UTF-8">
    @csrf
    <div id="form-errors" class="alert alert-warning" style="display: none"></div>
    <!--hidden id input-->
    <input type="hidden" name="user_id" id="user_id">

        <!--Card of General Information-->
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">User Information:</h2>
            </div>
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
                                <select class="form-control" name="role" id="role">
                                    <option selected="selected" value="">Select role...</option>
                                    @foreach($roles as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
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
        <!--Card of Address Fields-->
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Address Information:</h2>
            </div>
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

                    <!--address input-->
                    <div class="form-group">
                        <label for="address">Full Address:</label>
                        <textarea rows="4" class="form-control" name="address" id="address" value="{{old('address')}}"></textarea>
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
        </div> 
        <!--Card of Password Fields-->
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Password:</h2>
            </div>
                <div class="card-body">
                    <!-- Contact input group -->
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
        </div> 
        <!--Card of Contact Fields-->
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Contact Information:</h2>
            </div>
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
                                    @foreach($contact_labels as $key => $value)
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
        </div> 

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


@stop