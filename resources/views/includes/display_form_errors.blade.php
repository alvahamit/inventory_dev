@if(count($errors) > 0)
<div class="alert alert-warning alert-dismissible fade show">
    <strong>Warning!</strong> One or more fields are empty:
    <ol>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ol>

    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif