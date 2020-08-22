<!-- 
    Author:     Alvah Amit Halder
    Document:   Transfer Challan print blade using letterhead template from theme.
    Model/Data: App\Challan
    Controller: ChallanssController@printtrch
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

@section('pageheading')<h4 class="display-4">{{$type}} Challan</h4>@stop

@section('content')

<div class="col-12 mt-5">
    <div class="row">
        <div class="col-6"><strong>Ref No #</strong> {!! strtoupper($challan->challan_no) !!}</div>
        <div class="offset-6 text-right"><strong>Date:</strong> {{$challan->challan_date}}</div>
    </div>
    <div style="margin-top: -1%">
        <div class="row">
            <div class="col-6">
                <strong>Issued by: </strong>
                @if($challan->issued_by !== null)
                {{$challan->issued_by}}
                @endif
            </div>
        </div>
    </div>
    <div style="margin-top: 2%">        
        <div class="row">
            <div class="col-6"><strong>From: </strong>{{ $challan->store_name }}</div>
            <div class="offset-6 text-right"><strong>To: </strong>{{ $challan->to_store_name }}</div>
        </div>
    </div>
    
    <h5>Challan Details</h5>

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
    
    <div style="margin-top: 3%">
        <div class="row">
            <div class="col-6"><strong>Approved by: </strong></div>
        </div>
    </div>
    


</div>

@stop