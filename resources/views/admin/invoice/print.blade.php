<!-- 
    Author:     Alvah Amit Halder
    Document:   Invoice print blade using letterhead template from theme.
    Model/Data: App\Invoice
    Controller: InvoicesController
-->
@extends('theme.letterhead')
@php
switch ($invoice->invoice_type)
{
case config('constants.invoice_type.whole'):
$type = 'Sales (Whole)';
break;
case config('constants.invoice_type.partial'):
$type = 'Sales (Partial)';
break;
case config('constants.invoice_type.sample'):
$type = 'Sample';
break;
default:
$type = 'Sales (Whole)';
}
@endphp

@section('title', __('VSF-Print Invoice'))

@section('pageheading')<h3 class="display-3">Invoice</h3>@stop

@section('content')    

<div class="col-12 mt-5">
    <div class="row">
        <div class="col-6">
            <strong>Invoice No#</strong> {!! strtoupper($invoice->invoice_no) !!}
        </div>
        <div class="offset-6 text-right">
            <strong>Date:</strong> {{$invoice->invoice_date}} <br>
            <strong>Type:</strong> {{$type}}
        </div>
    </div>
    
    <div class="row">
        <div class="col-6">
            <strong>Invoiced By:</strong><br>
            {!! nl2br($invoice->invoiced_by) !!}
            <br>
        </div>
        <div class="offset-6 text-right">
            <strong>Billed to:</strong><br>
            {!! nl2br($invoice->billed_to) !!}
            <br>
        </div>
    </div>
    
    <div style="margin-top: -14%">
        <div class="row col-12">
            <h5><strong>Invoice Details </strong></h5>
        </div>
    </div>
    
    <div class="row col-12">
        <table class="table">
            <thead>
                <tr>
                    <th><strong>Item Name</strong></th>
                    <th><strong>Packing</strong></th>
                    <th class="text-center"><strong>Rate</strong></th>
                    <th class="text-center"><strong>Qty.</strong></th>
                    <th class="text-right"><strong>Total</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->products as $item)
                <tr>
                    <td>{{$item->pivot->item_name}}</td>
                    <td>{{$item->pivot->item_unit}}</td>
                    <td class="text-center">{{ "Tk. ".number_format($item->pivot->unit_price,2) }}</td>
                    <td class="text-center">{{$item->pivot->item_qty}}</td>
                    <td class="text-right">{{ "Tk. ".number_format($item->pivot->item_total,2) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td class="emptyrow"></td>
                    <td class="emptyrow"></td>
                    <td class="emptyrow"></td>
                    <td class="text-right"><strong>Discount</strong></td>
                    <td class="text-right">{{ "(Tk. ".number_format($invoice->discount,2).")" }}</td>
                </tr>
                <tr>
                    <td class="emptyrow"></td>
                    <td class="emptyrow"></td>
                    <td class="emptyrow"></td>
                    <td class="text-right"><strong>Carrying</strong></td>
                    <td class="text-right">{{ "Tk. ".number_format($invoice->carrying,2) }}</td>
                </tr>
                <tr>
                    <td class="emptyrow"></td>
                    <td class="emptyrow"></td>
                    <td class="emptyrow"></td>
                    <td class="text-right"><strong>Others</strong></td>
                    <td class="text-right">{{ "Tk. ".number_format($invoice->other_charge,2) }}</td>
                </tr>
                <tr>
                    <td class="emptyrow"></td>
                    <td class="emptyrow"></td>
                    <td class="emptyrow"></td>
                    <td class="text-right"><strong>Total</strong></td>
                    <td class="text-right">{{ "Tk. ".number_format($invoice->invoice_total,2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="text-center">
                <strong>Inwords: Taka {{$invoice->inwords}} only.</strong>
            </div>
        </div>
    </div>
    
</div>

<style>
    table tr td{
        font-size: 10pt;
    }
</style>

@stop