<!-- 
    Author:     Alvah Amit Halder
    Document:   Dashboard. 
    Theme:      SB Admin 2
    Controller: HomeController
-->
@extends('theme.default')

@section('title', __('VSF-Admin Dash'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Dashboard'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>

@include('admin.admin_dash.cards')

@include('theme.charts')

@stop

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('scripts')

@stop