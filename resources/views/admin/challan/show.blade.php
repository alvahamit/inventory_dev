<!-- 
    Author:     Alvah Amit Halder
    Document:   Delivery challan show blade.
    Model/Data: App\Challan
    Controller: ChallansController
-->

@extends('theme.default')

@section('title', __('VSF-Challans'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Delivery Challan'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<div class="tab-pane fade show active" id="challan">
    <input type="hidden" id="challan_id" value="{{$challan->id}}">
    <h4 class="mt-2 pt-1 pb-2">
        Ref No # {{$challan->challan_no}} 
        <!--Print challan button-->
        <a id="printBtn" class="btn btn-warning btn-sm float-right"><i class="fas fa-print fa-lg"></i></a> 
        <a id="pdfBtn" class="btn btn-success btn-sm float-right mr-1"><i class="far fa-file-pdf fa-lg"></i></a>
    </h4>


    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 float-xs-right float-left text-md-left"><strong>Challan Date:</strong> {{$challan->challan_date}}</div>
                <div class="col-xs-12 col-md-6 col-lg-6 float-xs-right float-right text-md-right"><strong>Order #:</strong> {{$challan->order_no}}</div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 float-xs-left float-left text-md-left">
                    <div class="col-md-6 float-left">
                        <strong>Challan by:</strong><br>
                        VSF Distribution<br>
                        7/1/A Lake Circus<br>
                        Kolabagan, North Dhanmondi<br>
                        Dhaka 1205<br>
                        From: {{ $challan->store_name }}
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 float-xs-right float-right text-md-right">
                    <div class="col-md-6 float-right">
                        <strong>Deliver to:</strong><br>
                        {{$challan->customer_name}}<br>
                        {{$challan->delivery_address}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h3 class="text-xs-center"><strong>Challan Details</strong></h3>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th><strong>Item Name</strong></th>
                                    <th><strong>Packing</strong></th>
                                    <th class="text-center"><strong>Quantity</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($challan->products as $item)
                                <tr>
                                    <td>{{$item->pivot->item_name}}</td>
                                    <td>{{$item->pivot->item_unit}}</td>
                                    <td class="text-center">{{$item->pivot->quantity}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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