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
        <h2 class="display-2">Money Receipt</h2>
        <div class="p-2">
        
        <div class="card" style="width: 100%;">
            <div class="card-body">
                <!--                <div class="card-header">
                                    <h4 class="text-center"><strong>Payment Acknowledgement Slip</strong></h4>
                                </div>-->
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

                <!--<div class="card-footer text-center"><small class="text-muted">Money Receipt by VSF.</small></div>-->
            </div>
        </div>
</div>





        <!--        <h2 class="display-2">Money Receipt</h2>
                <div class="row col-12 pb-5">
                    <div class="col-12">
                        <div>
                            <strong>MR No#</strong> {!! strtoupper($mr->mr_no) !!}<br>
                            <strong>MR Date:</strong> {{$mr->mr_date}}
                        </div>
                    </div>
                </div>-->




        <!--        <div class="card">
                    <div class="card-header">
                    <h4 class="text-center"><strong>Money Receipt</strong></h4>
                </div>
                    <div class="card-body">
                        <div class="row pt-2">
                            <div class="col-2"><strong class="text-muted">Date:</strong></div>
                            <div class="offset-2">{{$mr->mr_date}}</div>
                        </div>
                        <div class="row mt-0 pt-0">
                            <div class="col-2"><strong class="text-muted">MR No: </strong></div>
                            <div class="offset-2 cal-2">{{$mr->mr_no}}</div>
                        </div>
                    </div>
                    <div class="card-footer text-center"><small class="text-muted">System generated MR</small></div>
                </div>-->






        <!--        <div class="card mt-10">
                    <div class="card-block p-8">
                        <div class="row pt-2">
                            <div class="col-2"><strong class="text-muted">Date:</strong></div>
                            <div class="offset-2">{{$mr->mr_date}}</div>
                        </div>
                        <div class="row mt-0 pt-0">
                            <div class="col-2"><strong class="text-muted">MR No: </strong></div>
                            <div class="offset-2 cal-2">{{$mr->mr_no}}</div>
                        </div>
                        
                        
                        
                        <div class="row pt-2">
                            <div class="col-2"><span class="text-muted">Payee Name:</span></div>
                            <div class="col-3 offset-2">{{$mr->customer_name}}</div>
                        </div>
                        <div class="row">
                            <div class="col-2"><span class="text-muted">Company:</span></div>
                            <div class="col-3 offset-2">{{$mr->customer_company}}</div>
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-2"><span class="text-muted">Address:</span></div>
                            <div class="col-3 offset-2">{{$mr->customer_address}}</div>
                        </div>
                        <div class="row">
                            <div class="col-2"><span class="text-muted">Phone No:</span></div>
                            <div class="col-3 offset-2">{{$mr->customer_phone}}</div>
                        </div>
                        <div class="row">
                            <div class="col-2"><span class="text-muted">Email:</span></div>
                            <div class="col-3 offset-2">{{$mr->customer_email}}</div>
                        </div>
                        <div class="pl-3 pt-3 pb-3">
                            <div class="pb-3 pr-3">
                                <h4>
                                    <span class="text-muted">Received with thanks </span> Tk. {{$mr->amount}}
                                    <span class="text-muted">, in words Taka</span> {{ucwords($mr->inwords)}} <span class="text-muted">only.</span>
                                </h4> 
                            </div>
                            <div class="row">
                                <div class="col-2"><span class="text-muted">Pay mode:</span></div>
                                <div class="col-2 offset-2">{{ucfirst($mr->pay_mode)}}</div>
                            </div>
                            @if ($mr->pay_mode == "cheque")
                            <div class="row">
                                <div class="col-2"><span class="text-muted">Bank name:</span></div>
                                <div class="col-2 ">{{$mr->bank_name}}</div>
                            </div>
                            <div class="row">
                                <div class="col-2"><span class="text-muted">Cheque no:</span></div>
                                <div class="col-2 ">{{$mr->cheque_no}}</div>
                            </div>
                            @endif
                            @if ($mr->pay_mode == "bkash")
                            <div class="row">
                                <div class="col-2"><span class="text-muted">bKash trx no:</span></div>
                                <div class="col-2 ">{{$mr->bkash_tr_no}}</div>
                            </div>
                            @endif
        
                        </div>
                    </div>  ./card-block
        
                    
                </div> -->
        <!--./card -->
        <!--<div class="card-footer text-center"><small class="text-muted">System generated MR</small></div>-->


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