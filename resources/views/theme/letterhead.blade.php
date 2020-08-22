<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <!--<meta charset="utf-8">-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <title>@yield('title', 'VSF Letterhead')</title>
    </head>
    <body>
        <!--<img src="https://via.placeholder.com/140x120/800000/FFFFFF?text=Your+Logo" alt="logo" class="img-fluid float-right">-->
        <img src="{{asset('img/logo.png')}}" alt="logo" class="img-fluid float-right" style="width:170px; height:auto">
        <h3 class="display-3">@yield('pageheading', 'Heading')</h3>
        @yield('content','Your content goes here.')
        <footer class="footer text-center" style="position: fixed; width: 100%; bottom: 0; ">
            <small class="text-muted">{!! config('constants.default_address') !!}</small>            
            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        </footer>
    </body>
</html>