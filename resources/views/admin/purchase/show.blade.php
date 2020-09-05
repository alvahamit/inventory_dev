<!-- 
    Author:     Alvah Amit Halder
    Document:   Purchase's Show blade.
    Model/Data: App\Prrchase
    Controller: PurchasesController@show
-->
@extends('theme.default')

@section('title', __('VSF-Purchases'))

@section('logo', __('VSF Distribution'))

@section('pageheading')
Purchase Ref# {!! $purchase->ref_no !!}
@stop

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<div class="container">
    
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{route('print.purchase')}}" accept-charset="UTF-8">
                @csrf
                <input type="hidden" name="id" value="{{$purchase->id}}">
                <button type="submit" class="btn btn-primary float-right mr-1"><i class="far fa-file-pdf fa-lg"></i> PDF</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div><strong>Receive Date:</strong> {{$purchase->receive_date}}</div>
            <div class="col-xs-12 col-md-3 col-lg-3 float-xs-left float-right text-md-right">
                <strong>Supplier:</strong><br>
                {{$purchase->user->name}}<br>
                {{$purchase->user->organization}}<br>
                {{$purchase->user->email}}<br>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h3 class="text-xs-center"><strong>Purchase Details ({{$purchase->purchase_type}})</strong></h3>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <td><strong>Item Name</strong></td>
                                    <td><strong>Packing</strong></td>
                                    <td><strong>Expiry</strong></td>
                                    <td class="text-xs-center"><strong>Item Price</strong></td>
                                    <td class="text-xs-center"><strong>Item Quantity</strong></td>
                                    <td class="text-xs-right"><strong>Total</strong></td>
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
                                    <td class="text-xs-center">{{'Tk. '.number_format($item->pivot->unit_price,2)}}</td>
                                    <td class="text-xs-center">{{$item->pivot->quantity}}</td>
                                    <td class="text-xs-right">{{'Tk. '.number_format($item->pivot->item_total,2)}}</td>
                                </tr>
                                @endforeach
                                 <tr>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow text-xs-center"><strong>Others</strong></td>
                                    <td class="emptyrow text-xs-right">-</td>
                                </tr>
                                <tr>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow text-xs-center"><strong>Total</strong></td>
                                    <td class="emptyrow text-xs-right">{{'Tk. '.number_format($purchase->total,2)}}</td>
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