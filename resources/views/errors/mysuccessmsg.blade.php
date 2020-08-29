@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show">
    <strong>Awesome!!!</strong> {{ Session::get('success') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif