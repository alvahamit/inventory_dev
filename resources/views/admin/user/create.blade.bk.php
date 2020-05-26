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
<div class="card card-register mx-auto mt-5">
    <div class="card-header">Register new User</div>
    <div class="card-body">
        <form method="POST" action="{{route('users.store')}}" accept-charset="UTF-8">
            @csrf
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control" 
                        placeholder="Full user name" 
                        autofocus="autofocus" 
                        value="{{old('name')}}"
                    >
                    <label for="name">Type in full user name</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-control" 
                        placeholder="Email address"
                        value="{{old('email')}}"
                    >
                    <label for="email">Type in users email address</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <select class="form-control" name="role">
                            <option selected="selected" value="">Pick a role for the user...</option>
                            @foreach($roles as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-label-group">
                            <input 
                                type="password" 
                                name="password" 
                                id="inputPassword" 
                                class="form-control" 
                                placeholder="Password"
                            >
                            <label for="inputPassword">User's Password</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-label-group">
                            <input 
                                type="password" 
                                name="confirmPassword" 
                                id="confirmPassword" 
                                class="form-control" 
                                placeholder="Confirm password"
                                >
                            <label for="confirmPassword">Confirm password</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input type="file" name="image" id="image" class="form-control-file">
                    <label for="image">Upload user photo (optional)</label>
                </div>
            </div>
            <input class="btn btn-primary btn-block" type="submit" value="Register">
        </form>
        <!--        <div class="text-center">
                  <a class="d-block small mt-3" href="login.html">Login Page</a>
                  <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
                </div>-->
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
    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>
@stop