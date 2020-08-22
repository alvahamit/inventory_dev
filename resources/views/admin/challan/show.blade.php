<!-- 
    Author:     Alvah Amit Halder
    Document:   Delivery challan show blade.
    Model/Data: App\Challan
    Controller: ChallansController
-->

@extends('theme.default')

@section('title', __('VSF-Challans'))

@section('logo', __('VSF Distribution'))

@php
    switch ($challan->challan_type)
    {
        case config('constants.challan_type.sales'):
            $type = 'Sales';
            break;
        case config('constants.challan_type.transfer'):
            $type = 'Transfer';
            break;
        case config('constants.challan_type.sample'):
            $type = 'Sample';
            break;
        default:
            $type = 'Sales';
    }
@endphp  

@section('pageheading')
{{$type}} Challan
@stop

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!--<div class="tab-pane fade show active" id="challan">-->
<div class="col-md-8 offset-md-2">
    <input type="hidden" id="challan_id" value="{{$challan->id}}">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{route('print.challan')}}" accept-charset="UTF-8">
                @csrf
                <input type="hidden" name="id" value="{{$challan->id}}">
                <button type="submit" class="btn btn-primary float-right mr-1"><i class="far fa-file-pdf fa-lg"></i> PDF</button>
            </form>
        </div>
    </div>
    <h4 class="mt-2 pt-1 pb-2">
        Ref No # {{$challan->challan_no}} 
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
                        @if($challan->issued_by !== null)
                        {{$challan->issued_by}}<br>
                        @endif
                        {!! str_replace('&#13;&#10;','<br>', config('constants.default_address')) !!}<br>
                        From: {{ $challan->store_name }}
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 float-xs-right float-right text-md-right">
                    <div class="col-md-6 float-right">
                        <strong>Deliver to:</strong><br>
                        {!! nl2br($challan->delivery_address) !!}
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
</style>

@stop