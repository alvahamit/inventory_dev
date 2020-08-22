<!-- 
    Author:     Alvah Amit Halder
    Document:   Challan print blade using letterhead template from theme.
    Model/Data: App\Challan
    Controller: ChallanssController
-->

@extends('theme.letterhead')

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

@section('title', __('VSF-Print Challan'))

@section('pageheading')<h3 class="display-3">{{$type}} Challan</h3>@stop

@section('content')

<div class="col-12 mt-5">
    <div class="row">
        <div class="col-6">
            <strong>Challan No#</strong> {!! strtoupper($challan->challan_no) !!}
            @if($challan->order_no)
            <br><strong>Order No#:</strong> {{$challan->order_no}}
            @endif
        </div>
        <div class="offset-6 text-right">
            <strong>Challan Date:</strong> {{$challan->challan_date}}<br>
            <strong>Deliver From: </strong>{{ $challan->store_name }}
        </div>
    </div>
    <div style="margin-top: -1%">
        <div class="row">
            @if($challan->order_no)
            <div class="col-6">
                <strong>Challan by:</strong><br>
                @if($challan->issued_by !== null)
                {{$challan->issued_by}}<br>
                @endif
                {!! str_replace('&#13;&#10;','<br>', config('constants.default_address')) !!}<br>

            </div>
            <div class="offset-6 text-right">
                <strong>Deliver to:</strong><br>
                {!! nl2br($challan->delivery_address) !!}
            </div>
            @endif
        </div>
    </div>
    
    <div style="margin-top: -14%">
        <h5>Challan Details</h5>
    </div>
    <div class="row">
        <table class="table">
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

@stop