@extends('layouts.admin')
@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Update Supplier</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<h1>Hi!! you can update suppliers here.</h1><hr>
<div class="card card-register mx-auto mt-5">
    <div class="card-header">Update Supplier</div>
    <div class="card-body">
        <form method="POST" action="{{route('suppliers.update', $data->id)}}" accept-charset="UTF-8">
            {{method_field('PATCH')}}
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
                        value="{{old('name',$data->name)}}"
                        required="required">
                    <label for="name">Update supplier's name</label>
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
                        value="{{old('email', $data->email)}}">
                    <label for="email">Update supplier's email address</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <select class="form-control" name="role">
                            <option value="">Pick supplier type...</option>
                            @foreach($roles as $key => $value)
                            
                            @if(!empty($data->role->first()) && $key == $data->role()->first()->id)
                            <option selected="selected" value="{{$key}}">{{$value}}</option>
                            @else
                            <option value="{{$key}}">{{$value}}</option>
                            @endif
                            
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input type="file" name="image" id="image" class="form-control-file">
                    <label for="image">Upload user photo (optional)</label>
                </div>
            </div>
            <!--Buttons with separete form for delete-->
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <input class="btn btn-primary btn-block" type="submit" value="Save">
                    </div> 
                    </form>
                    <div class="col-md-6">
                        <form method="POST" action="{{route('suppliers.destroy', $data->id)}}" accept-charset="UTF-8">
                            {{method_field('DELETE')}}
                            @csrf
                            <input class="btn btn-danger btn-block" type="submit" value="Delete">
                            </div> 
                        </form>
                    </div>
                </div>
                @include('includes.display_form_errors')
            </div>
    </div>
    
@stop