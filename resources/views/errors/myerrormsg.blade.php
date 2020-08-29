@if(Session::has('errors'))
<div class="alert alert-danger alert-dismissible fade show">
    <strong>Opps!!!</strong> {{ Session::get('errors') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif