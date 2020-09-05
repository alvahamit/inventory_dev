<!-- 
    Author:     Alvah Amit Halder
    Document:   Custome Error Template blade.
    Model/Data: 
    Controller: 
-->

@extends('theme.default')

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Forbidden'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<div class="page-wrap d-flex flex-row align-items-center mt-md-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <span class="display-1 d-block">@yield('code', __('Oh no'))</span>
                <div class="mb-4 lead">@yield('message')</div>
                <a href="{{ app('router')->has('home') ? route('home') : url('/') }}">
                    <button class="bg-transparent text-grey-darkest font-bold uppercase tracking-wide py-3 px-6 border-2 border-grey-light hover:border-grey rounded-lg">
                        {{ __('Go Home') }}
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Styles -->
<style>
   .bg-transparent {
        background-color: transparent;
    }
    .text-grey-darkest {
        color: #3d4852;
    }
    .font-bold {
        font-weight: 700;
    }
    .uppercase {
        text-transform: uppercase;
    }
    .tracking-wide {
        letter-spacing: .05em;
    }
    .py-3 {
        padding-top: .75rem;
        padding-bottom: .75rem;
    }
    .px-6 {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    .border-2 {
        border-width: 2px;
    }
    .border-grey-light {
        border-color: #dae1e7;
    }
    .hover\:border-grey:hover {
        border-color: #b8c2cc;
    }
    .rounded-lg {
        border-radius: .5rem;
    }
</style>

@stop