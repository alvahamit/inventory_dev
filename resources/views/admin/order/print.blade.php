<!-- 
    Author:     Alvah Amit Halder
    Document:   Order print blade using letterhead template from theme.
    Model/Data: App\Order
    Controller: OrdersController
-->
@extends('theme.letterhead')

@php
    switch ($order->order_type)
    {
        case config('constants.order_type.sales'):
            $type = 'Sales Order';
            break;
        case config('constants.order_type.sample'):
            $type = 'Sample Request';
            break;
        default:
            $type = 'Sales';
    }
@endphp       

@section('title', __('VSF-Print Order'))

@section('pageheading')<h3 class="display-3">Sales Order</h3>@stop

@section('content')   

<div class="col-12 mt-5">
    <div class="row">
        <div class="col-6">
            <strong>Ref No# </strong>{!! strtoupper($order->order_no) !!}
        </div>
        <div class="offset-6 text-right">
            <strong>Date: </strong>{{$order->order_date}}
        </div>
    </div>
 
    <div class="row">
        <div class="col-12">
            <strong>Customer Address:</strong><br>
            {{$order->customer_name}}<br>
            {{$order->customer_company}}<br>
            {!! nl2br($order->customer_address) !!}<br>
            {!!nl2br($order->customer_contact)!!}<br>
        </div>
        <div class="col-6 offset-6 text-right">
            <strong>Shipping Address:</strong><br>
            {{$order->shipp_to_name}}<br>
            {{$order->shipp_to_company}}<br>
            {!! nl2br($order->shipping_address) !!}<br>
            {!! nl2br($order->shipping_contact) !!}<br>
        </div>
    </div>
    
    <div style="margin-top: -14%">
        <div class="row">
            <div class="col-12">
                <h5><strong>Order Details </strong></h5>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th><strong>Item Name</strong></th>
                        <th><strong>Unit</strong></th>
                        <th class="text-center"><strong>Unit Price</strong></th>
                        <th class="text-center"><strong>Quantity</strong></th>
                        <th class="text-right"><strong>Total</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->products->all() as $item)
                    <tr>
                        <td>{{$item->pivot->product_name}}</td>
                        @if(!empty($order->quantity_type))
                        <td>{{$order->quantity_type}}</td>
                        @else
                        <td>{{$item->pivot->product_packing}}</td>
                        @endif
                        <td class="text-center">{{ "Tk. ".number_format($item->pivot->unit_price,2) }}</td>
                        @if(!empty($order->quantity_type))
                        <td class="text-center">{{$item->pivot->quantity}} {{$item->itemStock($order->quantity_type)['unit']}}</td>
                        @else
                        <td class="text-center">{{$item->pivot->quantity}} {{$item->itemStock()['unit']}}</td>
                        @endif
                        <td class="text-right">{{ "Tk. ".number_format($item->pivot->item_total,2) }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="text-center"><strong>Others</strong></td>
                        <td class="text-right">-</td>
                    </tr>
                    <tr>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="text-center"><strong>Total</strong></td>
                        <td class="text-right">{{ "Tk. ".number_format($order->order_total,2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="text-center"><strong>Inwords: Taka {{$order->inwords}} only.</strong></div>
        </div>
    </div>
</div>

<style>
    table tr td{
        font-size: 10pt;
    }
</style>

@stop