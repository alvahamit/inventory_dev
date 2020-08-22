<!-- 
    Author:     Alvah Amit Halder
    Document:   Purchase print blade using letterhead template from theme.
    Model/Data: App\Purchase
    Controller: PurchasesController
-->
@extends('theme.letterhead')

@section('title', __('VSF-Print Purchase'))

@section('pageheading')<h3 class="display-3">Purchase</h3>@stop

@section('content')        

<div class="col-12 mt-5">
    <div class="row">
        <div class="col-6">
            <strong>Ref#</strong> {!! strtoupper($purchase->ref_no) !!}<br>
            <strong>Date:</strong> {{$purchase->receive_date}}
        </div>
        <div class="offset-6 text-right">
            <strong>Supplier:</strong><br>
            {{$purchase->user->name}}<br>
            {{$purchase->user->organization}}<br>
            {{$purchase->user->email}}<br>
        </div>
    </div>
    <div style="margin-top: 1%">
        <div class="col-12">
            <h5>Purchase Details ({{$purchase->purchase_type}})</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th><strong>Item Name</strong></th>
                        <th><strong>Packing</strong></th>
                        <th><strong>Expiry</strong></th>
                        <th class="text-center"><strong>Price</strong></th>
                        <th class="text-center"><strong>Qty.</strong></th>
                        <th class="text-right"><strong>Total</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchase->products->all() as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>
                            {{ 
                            $item->packings()->first()->name.", "
                            .$item->packings()->first()->quantity
                            .$item->units()->first()->short." x "
                            .$item->packings()->first()->multiplier 

                            }}
                        </td>
                        <td>{{$item->pivot->expire_date}}</td>
                        <td class="text-right">{{'Tk. '.number_format($item->pivot->unit_price,2)}}</td>
                        <td class="text-center">{{$item->pivot->quantity}}</td>
                        <td class="text-right">{{'Tk. '.number_format($item->pivot->item_total,2)}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="text-center"><strong>Others</strong></td>
                        <td class="emptyrow">-</td>
                    </tr>
                    <tr>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="text-center"><strong>Total</strong></td>
                        <td class="text-right">{{'Tk. '.number_format($purchase->total,2)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <br>
        <!--<div class="text-center"><strong>Inwords: Taka {{$purchase->inwords}} only.</strong></div>-->
    </div>
    <div class="row text-center">
        <strong>Inwords: Taka {{$purchase->inwords}} only.</strong>
    </div>    
</div>

<style type="text/css">
    table tr td {
        font-size: 10pt;
    }
</style>



@stop