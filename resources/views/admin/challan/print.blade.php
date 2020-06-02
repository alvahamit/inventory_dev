<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <title>VSF-Print Invoice</title>
    </head>
    <body>
        <!--html code here-->
        <h2 class="display-2">Sales Challan</h2>
        <div class="row col-12 pb-5">
            <div class="col-md-12">
                <div>
                    <strong>Challan No#</strong> {!! strtoupper($challan->challan_no) !!}<br>
                    <strong>Challan Date:</strong> {{$challan->challan_date}}<br>
                    @if($challan->order_no)
                    <strong>Order No#:</strong> {{$challan->order_no}}
                    @endif
                </div>
            </div>
        </div>
        <div class="row col-12">
            @if($challan->order_no)
            <div class="col-6">
                <strong>Challan by:</strong><br>
                VSF Distribution<br>
                7/1/A Lake Circus<br>
                Kolabagan, North Dhanmondi<br>
                Dhaka 1205<br>
                <strong>From: </strong>{{ $challan->store_name }}
            </div>
            <div class="col-6 offset-6 text-right">
                <strong>Deliver to:</strong><br>
                {{$challan->customer_name}}<br>
                {{$challan->delivery_address}}
            </div>
            @endif
        </div>
        <div class="row col-12">
            <h5><strong>Challan Details </strong></h5>
        </div>
        
        <div class="row col-12">
            <div class="table-responsive">
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