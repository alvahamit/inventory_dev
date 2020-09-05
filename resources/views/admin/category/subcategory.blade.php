<li><span><i class="fas fa-tag text-info"></i> </span>
    <a href="{{ $childCategory->id }}" class="edit">{{ $childCategory->name }}</a> 
    <div class="btn-group">
        <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </button>
        <div class="dropdown-menu">
            <a class="add dropdown-item" href="{{ $childCategory->id }}"><i class="fas fa-plus"></i> Add</a>
            <a class="del dropdown-item" href="{{ $childCategory->id }}"><i class="fas fa-trash-alt"></i> Delete</a>
        </div>
    </div>
</li>
@if ($childCategory->categories)
    <ul>
        @foreach ($childCategory->categories as $childCategory)
            @include('admin.category.subcategory', ['child_category' => $childCategory])
        @endforeach
    </ul>
@endif