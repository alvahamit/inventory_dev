<!-- 
    Author:     Alvah Amit Halder
    Document:   Money Receipt(MR) show blade.
    Model/Data: App\MoneyReceipt as Customer.
    Controller: MoneyReceiptController
-->

@extends('theme.default')

@section('title', __('VSF-Money Receipt'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Money Receipt'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('mrs.index') }}">Money Receipts</a>
    </li>
    <li class="breadcrumb-item active">{{$mr->mr_no}}</li>
</ol>


<div class="container">
    <div class="col-md-12">
<!--        <div class="row">
            <div class="col-md-6 text-left"><h5><strong>MR Date: </strong> {{$mr->mr_date}}</h5></div>
            <div class="col-md-6 text-right"><h5><strong>MR No: </strong> {{$mr->mr_no}}</h5></div>
        </div>-->
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{route('print.mr')}}" accept-charset="UTF-8">
                    @csrf
                    <input type="hidden" name="id" value="{{$mr->id}}">
                    <button type="submit" class="btn btn-primary float-right mr-1"><i class="far fa-file-pdf fa-lg"></i> PDF</button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="text-md-center"><strong>Money Receipt</strong></h4>
            </div>
            <div class="card-block">
                <div class="row pl-3 pt-2">
                    <div class="col-md-1"><strong class="text-muted">Date:</strong></div>
                    <div class="col-md-3">{{$mr->mr_date}}</div>
                </div>
                <div class="row pl-3">
                    <div class="col-md-1"><strong class="text-muted">MR No: </strong></div>
                    <div class="col-md-3">{{$mr->mr_no}}</div>
                </div>
                <div class="row pt-2">
                    <div class="col-md-2 offset-7"><span class="text-muted">Payee Name:</span></div>
                    <div class="col-md-3 ">{{$mr->customer_name}}</div>
                </div>
                <div class="row">
                    <div class="col-md-2 offset-7"><span class="text-muted">Company:</span></div>
                    <div class="col-md-3 ">{{$mr->customer_company}}</div>
                </div>
                <div class="row">
                    <div class="col-md-2 offset-7"><span class="text-muted">Address:</span></div>
                    <div class="col-md-3 ">{{$mr->customer_address}}</div>
                </div>
                <div class="row">
                    <div class="col-md-2 offset-7"><span class="text-muted">Phone No:</span></div>
                    <div class="col-md-3 ">{{$mr->customer_phone}}</div>
                </div>
                <div class="row">
                    <div class="col-md-2 offset-7"><span class="text-muted">Email:</span></div>
                    <div class="col-md-3 ">{{$mr->customer_email}}</div>
                </div>
                <div class="pl-3 pt-3 pb-3">
                    <div class="pb-3 pr-3">
                        <h4>
                            <span class="text-muted">Received with thanks </span> Tk. {{$mr->amount}}
                            <span class="text-muted">, in words Taka</span> {{ucwords($mr->inwords)}} <span class="text-muted">only.</span>
                        </h4> 
                    </div>
                    <div class="row">
                        <div class="col-md-2"><span class="text-muted">Pay mode:</span></div>
                        <div class="col-md-2 ">{{ucfirst($mr->pay_mode)}}</div>
                    </div>
                    @if ($mr->pay_mode == "cheque")
                    <div class="row">
                        <div class="col-md-2"><span class="text-muted">Bank name:</span></div>
                        <div class="col-md-2 ">{{$mr->bank_name}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><span class="text-muted">Cheque no:</span></div>
                        <div class="col-md-2 ">{{$mr->cheque_no}}</div>
                    </div>
                    @endif
                    @if ($mr->pay_mode == "bkash")
                    <div class="row">
                        <div class="col-md-2"><span class="text-muted">bKash trx no:</span></div>
                        <div class="col-md-2 ">{{$mr->bkash_tr_no}}</div>
                    </div>
                    @endif
                    
                </div>
            </div> <!--./card-block-->
            <div class="card-footer"><small class="text-muted">System generated MR</small></div>
        </div> <!--./card -->
    </div> <!--./col-md-12-->
</div> <!-- ./container -->

<style>
    .card{margin-top: 10px}
    .card .card-block{padding: 8px}
    .height {
        min-height: 200px;
    }

    .icon {
        font-size: 47px;
        color: #5CB85C;
    }

    .iconbig {
        font-size: 77px;
        color: #5CB85C;
    }

    .table > tbody > tr > .emptyrow {
        border-top: none;
    }

    .table > thead > tr > .emptyrow {
        border-bottom: none;
    }

    .table > tbody > tr > .highrow {
        border-top: 3px solid;
    }
</style>


@stop