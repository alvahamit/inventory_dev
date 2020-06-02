<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <title>VSF-Purchase Print</title>
    </head>
    <body>
        <!--html code here-->
        <h2 class="display-2">Purchase</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <strong>Ref#</strong> {!! strtoupper($purchase->ref_no) !!}<br>
                            <strong>Receive Date:</strong> {{$purchase->receive_date}}
                        </div>
                        <div class="float-right pb-5">
                            <strong>Supplier:</strong><br>
                            {{$purchase->user->name}}<br>
                            {{$purchase->user->organization}}<br>
                            {{$purchase->user->email}}<br>

                        </div>
                    </div>
                </div>
                <h5 class="mt-5 pt-5"><strong>Purchase Details ({{$purchase->purchase_type}})</strong></h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <td><strong>Item Name</strong></td>
                                <td><strong>Packing</strong></td>
                                <td><strong>Expiry</strong></td>
                                <td class="text-center"><strong>Item Price</strong></td>
                                <td class="text-center"><strong>Item Quantity</strong></td>
                                <td class="text-right"><strong>Total</strong></td>
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
                    <br>
                    <div class="text-center"><strong>Inwords: Taka {{$purchase->inwords}} only.</strong></div>
                </div>
            </div>
        </div>
        
        <footer class="footer" style="position: fixed; width: 100%; bottom: 0; ">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <small class="text-muted">This is a system generated document. Copyright &copy; Alvah Amit Halder 2020</small>
                </div>
            </div>

            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

        </footer>
    </body>
</html>