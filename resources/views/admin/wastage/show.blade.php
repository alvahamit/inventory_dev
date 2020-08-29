<!-- 
    Author:     Alvah Amit Halder
    Document:   Wastage show blade.
    Model/Data: App\Wastage
    Controller: WastageController@show
-->

@extends('theme.default')

@section('title', __('VSF-Wastages'))

@section('logo', __('VSF Distribution'))

@section('pageheading',__('Wastage Report'))


@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')

<div class="col-md-8 offset-md-2">
    <input type="hidden" id="wastage_id" value="{{$wastage->id}}">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{route('print.wastage')}}" accept-charset="UTF-8">
                @csrf
                <input type="hidden" name="id" value="{{$wastage->id}}">
                <button type="submit" class="btn btn-primary float-right mr-1"><i class="far fa-file-pdf fa-lg"></i> PDF</button>
            </form>
        </div>
    </div>
    <div class="container mt-5 pt-3 pb-3" style="background-color:white;">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-6 float-xs-right float-left text-md-left"><strong>Ref # </strong> {{$wastage->wastage_no}}</div>
                    <div class="col-xs-12 col-md-6 col-lg-6 float-xs-right float-right text-md-right"><strong>Date:</strong> {{$wastage->wastage_date}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-6 float-xs-left float-left text-md-left">
                        <!--<div class="col-md-6 float-left">-->
                        @if($wastage->issued_by !== null)
                        <strong>Issued by:</strong> {{$wastage->issued_by}}<br>
                        @endif
                        <b>Wasted at:</b> {{ $wastage->wasted_at }}
                        <!--</div>-->
                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-6 float-xs-right float-right text-md-right">
                        @if($wastage->store_id != null)
                        <strong>Store:</strong> {!! $wastage->store_name !!}<br>
                        @endif
                        <strong>Qty type:</strong> {!! config('constants.quantity_type.'.$wastage->quantity_type) !!}
                    </div>
                </div>
            </div>
        </div>
        <!--Wastage items-->
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h3 class="text-xs-center"><strong>Wastage Details</strong></h3>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-sm">
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
                    </div>
                </div>
            </div>
        </div>
        <!--Report-->
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">Report</div>
                    <div class="card-block">{{$wastage->report}}</div>
                </div>
            </div>
        </div>
        <!--Approval-->
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <!--<div class="card-header">Report</div>-->
                    <div class="card-block">
                        <div class="row">
                        @if($wastage->is_approved)
                        <div class="col-md-6">
                            Approval Status: <b>Approved</b>
                        </div>
                        <div class="col-md-6 text-md-right">
                            Approved by: <b>{{$wastage->approved_by}}</b>
                        </div>
                        @else
                        <div class="col-md-6">
                            Approval Status: <b>Unapproved</b>
                        </div>
                        @endif
                        </div>
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