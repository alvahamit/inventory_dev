<!-- 
    Author:     Alvah Amit Halder
    Document:   Invoice show blade.
    Model/Data: App\Invoice
    Controller: InvoicesController
-->

@extends('theme.default')

@section('title', __('VSF-Invoice'))

@section('logo', __('VSF Distribution'))

@php
    switch ($invoice->invoice_type)
    {
        case config('constants.invoice_type.whole'):
            $type = 'Sales (Whole)';
            $type_val = config('constants.invoice_type.whole');
            break;
        case config('constants.invoice_type.partial'):
            $type = 'Sales (Partial)';
            $type_val = config('constants.order_type.partial');
            break;
        case config('constants.invoice_type.sample'):
            $type = 'Sample';
            $type_val = config('constants.order_type.sample');
            break;
        default:
            $type = 'Sales (Whole)';
            $type_val = config('constants.order_type.whole');
    }
@endphp

@section('pageheading')
Invoice - {{$type}} 
@stop

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<div class="tab-pane fade show active" id="invoice">
    <input type="hidden" id="invoice_id" value="{{$invoice->id}}">
    <form method="post" action="{{route('print.invoice')}}" accept-charset="UTF-8">
        @csrf
        <input type="hidden" name="id" value="{{$invoice->id}}">
        <button type="submit" class="btn btn-primary float-right mr-1"><i class="far fa-file-pdf fa-lg"></i> PDF</button>
    </form>
    <h4 class="mt-2 pt-1 pb-2">
        Ref No # {{$invoice->invoice_no}} 
    </h4>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 float-xs-right float-left text-md-left"><strong>Invoice Date:</strong> {{$invoice->invoice_date}}</div>
                <div class="col-xs-12 col-md-6 col-lg-6 float-xs-right float-right text-md-right"><strong>Order #:</strong> {{$invoice->order_no}}</div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 float-xs-left float-left text-md-left">
                    <div class="col-md-6 float-left">
                        <strong>Invoiced by:</strong><br>
                        {!! nl2br($invoice->invoiced_by) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 float-xs-right float-right text-md-right">
                    <div class="col-md-6 float-right">
                        <strong>Billed to:</strong><br>
                        {!! nl2br($invoice->billed_to) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h3 class="text-xs-center"><strong>Invoice Details</strong></h3>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th><strong>Item Name</strong></th>
                                    <th><strong>Packing</strong></th>
                                    <th class="text-center"><strong>Unit Price</strong></th>
                                    <th class="text-center"><strong>Quantity</strong></th>
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
                                    <td class="emptyrow text-right"><strong>Discount</strong></td>
                                    <td class="emptyrow text-right">{{ "(Tk. ".number_format($invoice->discount,2).")" }}</td>
                                </tr>
                                <tr>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow text-right"><strong>Carrying</strong></td>
                                    <td class="emptyrow text-right">{{ "Tk. ".number_format($invoice->carrying,2) }}</td>
                                </tr>
                                <tr>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow text-right"><strong>Others</strong></td>
                                    <td class="emptyrow text-right">{{ "Tk. ".number_format($invoice->other_charge,2) }}</td>
                                </tr>
                                <tr>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow text-right"><strong>Total</strong></td>
                                    <td class="emptyrow text-right">{{ "Tk. ".number_format($invoice->invoice_total,2) }}</td>
                                </tr>
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