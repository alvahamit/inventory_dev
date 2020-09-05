<!-- 
    Author:     Alvah Amit Halder
    Document:   Categories Index blade.
    Model/Data: App\Category
    Controller: CategoryController
-->

@extends('theme.default')

@section('title', __('VSF-Category'))

@section('logo', __('VSF Distribution'))

@section('pageheading', __('Category Tree'))

@section('footer', __('Copyright © Alvah Amit Halder 2019'))

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">Categories</li>
</ol>
@include('errors.myerrormsg')
@include('errors.mysuccessmsg')
<!--Add new button-->
<div class="form-group text-right">
    <!--<a class="btn btn-primary right" href="{{route('categories.create')}}">Add new</a>-->
    <button id="createNew" class="btn btn-primary right">New Category</button>
</div> 
<!--Data table-->
<!--<div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Categories Data Table </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td><a href="{{route('categories.edit',$item->id)}}">{{$item->name}}</a></td>
                        <td>{{$item->description}}</td>
                        <td>{{!empty($item->created_at) ? $item->created_at->diffForHumans() : ''}}</td>
                        <td>{{!empty($item->updated_at) ? $item->updated_at->diffForHumans() : ''}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated {{now()->format('g:i a l jS F Y')}}</div>
</div>-->

<!--New Code-->
<div class="col-md-6">
    <div class="tree">
        <ul id='category'>
            @foreach ($data as $category)
            <li><span><i class="fas fa-thumbtack text-primary"></i> </span>
                <a href="{{ $category->id }}" class="lead font-weight-bold edit">{{ $category->name }}</a>
                
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="add dropdown-item" href="{{ $category->id }}"><i class="fas fa-plus"></i> Add</a>
                        <a class="del dropdown-item" href="{{ $category->id }}"><i class="fas fa-trash-alt"></i> Delete</a>
                    </div>
                </div>
            </li>
            <ul>
                @foreach ($category->childrenCategories as $childCategory)
                @include('admin.category.subcategory', ['child_category' => $childCategory])
                @endforeach
            </ul>
            @endforeach
        </ul>
    </div>
</div>

<!--Code for Modal-->
<div class="modal" tabindex="-1" role="dialog" id="ajaxModel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 id="modelHeading" class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--Category Form-->
        <form id="catagoryForm" name="orderForm" class="form-horizontal" autocomplete="off">
            <div id="form-errors" class="alert alert-warning alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            @csrf
            <!--hidden id input-->
            <input type="hidden" name="id" id="id">
            <!--Category Select Options-->
            <fieldset id="catOptions">
                <div class="form-group">
                    <label class="col-form-label col-form-label-sm" for="quantity_type">Parent Category: </label>
                    <select id="category_id" name="category_id" class="custom-select custom-select-sm">
                        <option value="">Select parent category...</option>
                        @foreach ($allCat as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    <input type="text" id="parent" class="form-control form-control-sm" readonly="readonly" style="display:none">
                </div>
            </fieldset>
            
            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="name">Category Name:</label>
                <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{old('name')}}">
            </div>
            
            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="description">Description:</label>
                <textarea type="text" name="description" id="description" class="form-control" rows="3">{!! old('description') !!}</textarea>
            </div>
            <div class="form-group">
                <input type="checkbox" id="root" name="root" value="1">
                <label class="col-form-label col-form-label-sm" for="root"> Is this a root Category?</label>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button name="saveBtn" id="saveBtn" type="submit" class="btn btn-primary" value="create-order">Save</button>
        <button name="closeBtn" id="closeBtn" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<style type="text/css">
    .tree {
    min-height:20px;
    padding:19px;
    margin-bottom:20px;
    background-color:#fbfbfb;
    border:1px solid #999;
    -webkit-border-radius:4px;
    -moz-border-radius:4px;
    border-radius:4px;
    -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    -moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)
}
.tree li {
    list-style-type:none;
    margin:0;
    padding:10px 5px 0 5px;
    position:relative
}
.tree li::before, .tree li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.tree li::before {
    border-left:1px solid #999;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.tree li::after {
    border-top:1px solid #999;
    height:20px;
    top:25px;
    width:25px
}
.tree li span {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border:1px solid #999;
    border-radius:5px;
    display:inline-block;
    padding:3px 8px;
    text-decoration:none
}
.tree li.parent_li>span {
    cursor:pointer
}
.tree>ul>li::before, .tree>ul>li::after {
    border:0
}
.tree li:last-child::before {
    height:30px
}
.tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
    background:#eee;
    border:1px solid #94a0b4;
    color:#000
}
</style>


@stop

@section('scripts')
<script type="text/javascript">
//Document Ready Function:
$(function() {
    
    /*
     * Get all Categories in Json
     */
    var allCat = <?php echo (json_encode($allCat)); ?>;
    //console.log(allCat);
    /*
    * Reset Modal:
    * Close (modal) function:
    */
    function closeModal(){
        $('#form-errors').hide();
        $('#saveBtn').html('Save');
        $('#catagoryForm').trigger("reset");
        $('#id').val('');
        $('#ajaxModel').modal('hide');
    } 
    
    $("#ajaxModel").on('hidden.bs.modal', function(){
        $('#parent').val('').hide();
        $('#category_id').show();
        $('#root').removeAttr('checked');
      });

   /*
    * @param {boolean} status
    * @param {string} message
    * @returns {String}
    * Description: This function is used to show page message.
    */
    function showMsg(status, message)
    {
        if(status == false)
        {
            var html =  '<div class="alert alert-warning alert-dismissible fade show">'+
                            '<strong>'+ message + '</strong>'+
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                        '</div>'
            return html;
        }
        if(status == true)
        {
            var html =  '<div class="alert alert-success alert-dismissible fade show">'+
                            '<strong>'+ message + '</strong>'+
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                        '</div>'
            return html;
        }
    }
    
    /*
    * Check if Category is root or not: 
    */
    $('#root').click(function(){
        if($(this).is(":checked")){
            $('#category_id').val(null).attr('selected', 'selected');
            $('#catOptions').prop('disabled',true).hide();
        } else {
            $('#catOptions').prop('disabled',false).show();
        }
    });

    /*
     * Create new order:
     * Show/View Modal Form.
     */
    $('#createNew').click(function () {
        $('#closeBtn').html("Close").removeClass('btn-danger').addClass('btn-secondary').val('close-modal');
        $('#saveBtn').val("create-order");
        $('#id').val('');
        $('#form-errors').hide();
        $('#catOptions').prop('disabled',false).show();
        $('#catagoryForm').trigger("reset");
        $('#modelHeading').html("Create Category");
        //Setup modal option:
        $('#ajaxModel').modal({
        backdrop: 'static',
                keyboard: false,
                closeButton: true,
        });
        //$('#closeBtn').show();
        $('#ajaxModel').modal('show');
        $('#ajaxModel').modal('handleUpdate');
    }); //Create New - Click function.
    
    /*
    * Action button actions:
    */
    $('#category').on('click', 'a.edit', function (e) {
        e.preventDefault();
        $('#catagoryForm').trigger("reset");
        var id = $(this).attr('href');
        var obj = $.grep(allCat, function(obj){return obj.id == id;})[0];
        //console.log(obj);
        $('#id').val(obj.id);
        $('#category_id').val(obj.category_id).attr('selected','selected');
        $('#name').val(obj.name);
        $('#description').val(obj.description);
        if(obj.category_id === null){
            $('#root').attr('checked', 'checked');
            $('#catOptions').prop('disabled',true).hide();
        } else {
            $('#root').removeAttr('checked');
            $('#catOptions').prop('disabled',false).show();
        }
        
        $('#closeBtn').html("Delete").removeClass('btn-secondary').addClass('btn-danger').val('delete');
        $('#saveBtn').val("update");
        $('#form-errors').hide();
        
        $('#modelHeading').html("Update Category");
        //Setup modal option:
        $('#ajaxModel').modal({
            backdrop: 'static',
            keyboard: false,
            closeButton: true,
        });
        $('#closeBtn').show();
        $('#ajaxModel').modal('show');
        $('#ajaxModel').modal('handleUpdate');
    });
    $('#category').on('click', 'a.add', function (e) {
        e.preventDefault();
        $('#catagoryForm').trigger("reset");
        var id = $(this).attr('href');
        var obj = $.grep(allCat, function(obj){return obj.id == id;})[0];
        //console.log(obj);
        $('#catOptions').prop('disabled',false).show();
        $('#category_id').val(obj.id).attr('selected','selected').hide();
        $('#parent').val(obj.name).show();
        
//        if(obj.category_id === null){
//            $('#root').attr('checked', 'checked');
//            $('#catOptions').prop('disabled',true).hide();
//        } else {
//            $('#root').removeAttr('checked');
//            $('#catOptions').prop('disabled',false).show();
//        }
        
        $('#closeBtn').html("Close").removeClass('btn-danger').addClass('btn-secondary').val('close-modal');
        $('#saveBtn').val("create-order");
        $('#id').val('');
        $('#form-errors').hide();
        $('#modelHeading').html("Create Category");
        //Setup modal option:
        $('#ajaxModel').modal({
            backdrop: 'static',
            keyboard: false,
            closeButton: true,
        });
        $('#ajaxModel').modal('show');
        $('#ajaxModel').modal('handleUpdate');
    });
    $('#category').on('click', 'a.del', function (e){
        e.preventDefault();
        var id = $(this).attr('href');
        // Confirm box
        bootbox.dialog({
            backdrop: true,
            centerVertical: false,
            size: '50%',
            closeButton: false,
            message: "<div class='text-center lead'>Are you doing this by mistake?<br>A record is going to be permantly deleted.<br>Please confirm your action!!!</div>",
            title: "Please confirm...",
            buttons: {
              success: {
                label: "Confirm",
                className: "btn-danger",
                callback: function() {
                    var action = '{{ route("categories.index") }}/'+id;
                    var method = 'DELETE';
                    $.ajax({
                        data: {"_token": "{{ csrf_token() }}"},
                        url: action,
                        type: method,
                        dataType: 'json',
                        success: function (data) {
                            //console.log(data);
                            location.reload(true);
                        },
                        error: function (data) {
                            console.log(data);
                            bootbox.alert('Category may have multilevel subcategoires. Try deleting category with single level subcategories first.');
                        }
                    }); // Ajax call
                }
              },
              danger: {
                label: "Cancel",
                className: "btn-success",
                callback: function() {
                    $('#modalForm').trigger("reset");
                    $('#deleteBtn').html('Delete');
                    $('#ajaxModel').modal('hide');
                }
              }
            }
          }) //Confirm Box
    });
    
    /*
    * Close button click event: 
    */
    $('#closeBtn').click(function(e){
        e.preventDefault();
        if($('#closeBtn').val() == "close-modal"){ 
            closeModal();
        }
        if($('#closeBtn').val() == "delete"){
            $(this).html('Deleting...'); 
            // Confirm box
            bootbox.dialog({
                backdrop: true,
                centerVertical: false,
                size: 'medium',
                closeButton: false,
                message: "{!! config('constants.messages.delete_alert') !!}",
                title: "Please confirm...",
                buttons: {
                  success: {
                    label: "Confirm",
                    className: "btn-danger",
                    callback: function() {
                        var id = $('#id').val();
                        var action = '{{ route("categories.index") }}/' + id;
                        var method = 'DELETE';
                        $.ajax({
                            data: $('#catagoryForm').serialize(),
                            url: action,
                            type: method,
                            dataType: 'json',
                            success: function (data) {
                                //console.log('Success:', data);
                                $('#catagoryForm').trigger("reset");
                                $('#closeBtn').html('Delete');
                                $('#ajaxModel').modal('hide');
                                location.reload(true);
                                //Page message:
                                //$('#pageMsg').html(showMsg(data.status, data.message));
                            },
                            error: function (data) {
                                //Change button text.
                                $('#closeBtn').html('Delete');
                                console.log('Error:', data);
                            }
                        }); // Ajax call
                    }
                  },
                  danger: {
                    label: "Cancel",
                    className: "btn-success",
                    callback: function() {
                        $('#orderForm').trigger("reset");
                        $('#closeBtn').html('Delete');
                        closeModal();
                    }
                  }
                }
            });
        }
    });
    
    
    /*
     * Save button click function:
     */
    $('#saveBtn').click(function(e){
        e.preventDefault();
        $(this).html('Sending..');
        var actionType = $(this).val();
        var mehtod;
        var action;
        if (actionType == 'create-order'){
            method = 'POST';
            action = '{{ route("categories.store") }}';
        };
        if (actionType == 'update'){
            method = 'PATCH';
            action = '{{ route("categories.index") }}' + '/' + $('#id').val();
        };
        //Ajax call to save data:
        $.ajax({
            data: $('#catagoryForm').serialize(),
            url: action,
            type: method,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                closeModal();
                location.reload(true);
                //$('#pageMsg').html(showMsg(data.status, data.message));
            },
            error: function (data) {
                console.log('Error:', data);    
                var errors = data.responseJSON.errors;
                var firstItem = Object.keys(errors)[0];
                var firstItemErrorMsg = errors[firstItem][0];
                //Set Error Messages:
                $('#form-errors').html('<strong>Attention!!!</strong> ' + firstItemErrorMsg);
                $('#form-errors').show();
                //Change button text.
                $('#saveBtn').html('Save');
                $("#ajaxModel .modal-body").animate({ scrollTop: 0 }, 1000);
            }
        }); // Ajax call
    });

    


    //Treeview collapse    
    $(function () {
        $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
        $('.tree li.parent_li > span').on('click', function (e) {
            var children = $(this).parent('li.parent_li').find(' > ul > li');
            if (children.is(":visible")) {
                children.hide('fast');
                $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
            } else {
                children.show('fast');
                $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
            }
            e.stopPropagation();
        });
    });

});
</script>

@stop