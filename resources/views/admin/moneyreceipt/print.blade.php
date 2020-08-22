<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <title>VSF-Print MR</title>
    </head>
    <body>
        <!--html code here-->
        <img src="https://via.placeholder.com/140x120/800000/FFFFFF?text=Your+Logo" alt="logo" class="img-fluid float-right">
        <h2 class="display-3">Money Receipt</h2>
        <div class="pt-5">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <p class="card-title" style="font-size: large">
                        <span class="text-muted">MR No#</span> {!! strtoupper($mr->mr_no) !!} 
                        <span class="float-right"><span class="text-muted">Date:</span> {{$mr->mr_date}}</span>
                    </p>
                    <p class="offset-6 card-text text-right">
                        <span class="card-subtitle text-muted">Received from: </span><br>
                        <span class="card-title">{{$mr->customer_name}}</span><br>
                        {{$mr->customer_company}}<br>
                        {!! $mr->customer_address !!}
                    </p>
                    <p class="card-text" style="font-size: x-large">
                        <span class="text-muted">Received with thanks </span> Tk. {{$mr->amount}}
                        <span class="text-muted">, in words Taka</span> {{ucwords($mr->inwords)}} <span class="text-muted">only.</span>               
                    </p>
                    <div class="row">
                        <div class="col-2"><span class="text-muted">Pay mode:</span></div>
                        <div class="offset-2">{{ucfirst($mr->pay_mode)}}</div>
                    </div>
                    @if ($mr->pay_mode == "cheque")
                    <div class="row">
                        <div class="col-2"><span class="text-muted">Bank name:</span></div>
                        <div class="offset-2">{{$mr->bank_name}}</div>
                    </div>
                    <div class="row">
                        <div class="col-2"><span class="text-muted">Cheque no:</span></div>
                        <div class="offset-2">{{$mr->cheque_no}}</div>
                    </div>
                    @endif
                    @if ($mr->pay_mode == "bkash")
                    <div class="row">
                        <div class="col-2"><span class="text-muted">bKash trx no:</span></div>
                        <div class="offset-2">{{$mr->bkash_tr_no}}</div>
                    </div>
                    @endif
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