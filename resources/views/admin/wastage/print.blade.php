<!-- 
    Author:     Alvah Amit Halder
    Document:   wastage print blade using letterhead template from theme.
    Model/Data: App\wastage
    Controller: wastageController@print
-->

@extends('theme.letterhead')

@section('title', __('VSF-Print Wastage'))

@section('pageheading')<h4 class="display-4">Wastage Report</h4>@stop

@section('content')

<div class="col-12 mt-5">
    <div class="row">
        <div class="col-6"><strong>Ref No #</strong> {!! strtoupper($wastage->wastage_no) !!}</div>
        <div class="offset-6 text-right"><strong>Date:</strong> {{$wastage->wastage_date}}</div>
    </div>
    <div style="margin-top: -1%">
        <div class="row">
            <div class="col-6">
                <strong>Issued by: </strong>
                @if($wastage->issued_by !== null)
                {{$wastage->issued_by}}
                @endif
            </div>
            <div class="offset-6 text-right"><b>Wasted at:</b> {{ $wastage->wasted_at }}</div>
        </div>
    </div>
    <div style="margin-top: -1%">        
        <div class="row">
            <div class="col-6"><strong>Qty type:</strong> {!! config('constants.quantity_type.'.$wastage->quantity_type) !!}</div>
            @if($wastage->store_id != null)
            <div class="offset-6 text-right"><strong>Store:</strong> {!! $wastage->store_name !!}</div>
            @endif
        </div>
    </div>
    
    <h5>Wastage Details</h5>

    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th><strong>Item Name</strong></th>
                    <th><strong>Description</strong></th>
                    <th class="text-center"><strong>Quantity</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach($wastage->stock as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->description}}</td>
                    <td class="text-center">
                        {{ number_format($item->qtyDenormalizer($wastage->quantity_type,$item->pivot->quantity),2) }} {{$item->itemStock($wastage->quantity_type)['unit']}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <h5>Report:</h5>
    <div style="margin-top: 1%">
        <div class="row">
            <div class="col-12">
                {{$wastage->report}}
            </div>
        </div>
    </div>
    
    <div style="margin-top: 3%">
        <div class="row">
            @if($wastage->is_approved)
            <div class="col-6">
                Approval Status: <b>Approved</b>
            </div>
            <div class="offset-6 text-right">
                Approved by: <b>{{$wastage->approved_by}}</b>
            </div>
            @else
            <div class="col-6">
                Approval Status: <b>Unapproved</b>
            </div>
            @endif
        </div>
    </div>
</div>

@stop