<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <title>VSF-Order Print</title>
    </head>
    <body>
        <!--html code here-->
        <h2 class="display-2">Sales Order</h2>
        <div class="row col-12 pb-5">
            <div class="col-md-12">
                <div>
                    <strong>Order No#</strong> {!! strtoupper($order->order_no) !!}<br>
                    <strong>Order Date:</strong> {{$order->order_date}}
                </div>
            </div>
        </div>
        <div class="row col-12">
            <div class="col-6">
                <strong>Customer Address:</strong><br>
                {{$order->customer_name}}<br>
                {{$order->customer_company}}<br>
                {{$order->customer_address}}<br>
                {{$order->customer_contact}}<br>
            </div>
            <div class="col-6 offset-6 text-right">
                <strong>Shipping Address:</strong><br>
                {{$order->shipp_to_name}}<br>
                {{$order->shipp_to_company}}<br>
                {{$order->shipping_address}}<br>
                {{$order->shipping_contact}}<br>
            </div>
        </div>
        <div class="row col-12">
            <h5><strong>Order Details </strong></h5>
        </div>
        
        <div class="row col-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <td><strong>Item Name</strong></td>
                            <td><strong>Unit</strong></td>
                            <td class="text-center"><strong>Unit Price</strong></td>
                            <td class="text-center"><strong>Quantity</strong></td>
                            <td class="text-right"><strong>Total</strong></td>
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
                <br>
                <div class="text-center"><strong>Inwords: Taka {{$order->inwords}} only.</strong></div>
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