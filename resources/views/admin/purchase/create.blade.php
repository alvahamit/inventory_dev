@extends('layouts.admin')
@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">New Purchase</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<h1>Hi!! you can register new purchases here.</h1><hr>
<div class="card mx-auto mt-5">
    <div class="card-header">Purchase Register</div>
    <div class="card-body">
        <form method="POST" action="{{route('purchases.store')}}" accept-charset="UTF-8">
            @csrf
            <!-- form-group -->
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-label-group">
                            <input type="text" 
                                   name="ref_no"
                                   id="ref_no" 
                                   class="form-control" 
                                   placeholder="Reference no." 
                                   autofocus="autofocus"
                                   value="{{old('ref_no')}}">
                            <label for="ref_no">Purchase reference no#</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-label-group">
                            <input type="date"
                                   name="receive_date"
                                   id="receive_date" 
                                   class="form-control"
                                   placeholder="receive_date"
                                   value="{{old('receive_date')}}">
                            <label for="receive_date">Receive Date</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./form-group -->

            <!-- form-group -->
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="user_id"
                                    id="user_id"
                                    class="form-control">
                                    <option value="">Select Supplier...</option>
                                    @foreach($data as $item)
                                    <option value="{{$item->id}}" {{old('user_id') == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                    @endforeach
                            </select>   
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="purchase_type"
                                    id="purchase_type"
                                    class="form-control">
                                <option value="">Purchase Type...</option>
                                @for($i=0; $i < count($purchase_types); $i++)
                                <option value="{{$purchase_types[$i]}}" {{old('purchase_type') == $purchase_types[$i] ? 'selected' : ''}}>{{$purchase_types[$i]}}</option>
                                @endfor
                                <!--<option value="Import">Import</option>-->
                                <!--<option value="Local">Local</option>-->
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./form-group -->


            <table class="table" id="items">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Manufacture Date</th>
                        <th>Expire Date</th>
                        <th>Item Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
<!--                    <tr id="set1" class="set">
                        <td>
                            <select name="product_ids[]" class="form-control">
                                <option value="">-- choose product --</option>
                                <option value="1">Product1 name ($100.00), Packing: Sack 25kgx1pcs</option>
                                <option value="2">Product2 name ($150.00), Packing: Corrugated Box 250mlx10pcs</option>
                            </select>
                        </td>
                        <td><input type="number" name="quantities[]" class="form-control"/></td>
                        <td><input type="number" id="unit_price1" name="unit_prices[]" class="form-control unit_price"/></td>
                        <td><input type="date" name="manufacture_dates[]" class="form-control"/></td>
                        <td><input type="date" name="expire_dates[]" class="form-control"/></td>
                        <td><input type="number" id="item_totals1" name="item_totals[]" class="form-control item_totals"/></td>
                        <td><button id="remove" type="button" class="close" data-dismiss="alert">&times;</button></td>
                        <td></td>
                    </tr>-->

                    <tr id="summery" style="display: none">
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="emptyrow text-xs-center"><strong>Total</strong></td>
                        <td class="emptyrow text-xs-right">
                            <input type="number"
                                   min="0"
                                   id="total"
                                   name="total"
                                   class="form-control" 
                                   placeholder="total" 
                                   required="required"
                                   value="{{old('total',0)}}"> 
                        </td>
                        <td class="emptyrow"></td>
                    </tr>
                </tbody>
            </table>
            @include('includes.display_form_errors')
            <!--Form buttons-->
            <a id="add-row" class="btn btn-secondary " href="#">+Row</a>
            <input type="submit" class="btn btn-primary" value="Save">
            <a class="btn btn-warning" href="#">Back</a>
         

        </form>
 
    </div> <!-- ./card-body -->
    
</div> <!-- ./card -->



<script>
    /*
     * This creates options for product selection: 
     * @param {int} id
     * @param {text} name
     * @param {Number} price
     * @param {text} packing
     * @returns {String}
     */
    function addOption(id,name,price,packing){
        return '<option value="'+id+'">'+name+' (Tk.'+price+'), Packing: '+packing+'</option>';
    }
    
    /*
     * This calculates item subtotal.
     * @param {Number} row_no
     * @returns {Number}
     */
    function subTotal(row_no){
        return $('#qty'+row_no).prop('value')*$('#unit_price'+row_no).prop('value');
    }
    
    
$(document).ready(function(){
    var productOptions; //This value is set by ajax call.
    /*
     * Axax Call goes to:
     * PurchaseController@getProdData
     */
    $.ajax({
            url: "/v2/purchases/getProdData",
            type: "POST",
            data:{ 
                _token:'{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            success: function(response){
                let items = response.items;
                productOptions = response.items;
            }
        });
    
    
    /*
     * Adding Dynamic Rows
     */ 
    $("#add-row").click(function(e){
        e.preventDefault();
        $("#summery").show();
        var row_count = $('#items tr').length-2;
        var row_no = +row_count + 1; 
        var trID = 'set'+ row_no; //This is the table row ID for new row.
        var options; //To store options for product choice.
        //Javascript to itarate through productOptions:
        productOptions.forEach(function(option){
            //console.log(option);
            options += addOption(option.id,option.name,option.price,option.packing);
        });
        // Storing HTML code block in a variable
        var html = '<tr id="'+trID+'" class="set">'+
                        '<td>'+
                            '<select name="product_ids[]" class="form-control">'+
                                '<option value="">-- Choose Product --</option>'+
                                 options+
                            '</select>'+
                        '</td>'+
                        '<td><input type="number" min="0" id="qty'+row_no+'" name="quantities[]" class="form-control qty"/></td>'+
                        '<td><input type="number" min="0" id="unit_price'+row_no+'" name="unit_prices[]" class="form-control unit_price"/></td>'+
                        '<td><input type="date" name="manufacture_dates[]" class="form-control"/></td>'+
                        '<td><input type="date" name="expire_dates[]" class="form-control"/></td>'+
                        '<td><input type="number" min="0" id="item_total'+row_no+'"  name="item_totals[]" class="form-control item_total"/></td>'+
                        '<td><button id="remove'+row_no+'" type="button" class="close" data-dismiss="alert">&times;</button></td>'+
                    '</tr>';

        //$('#items').append(html);  
        //$('#items').find('tr:last').prev().after(html);
        $('#summery').before(html);
        
        /*
        * Removing Dynamic Rows 
        * and trigger change for recalculate.
        */
        $('.close').click(function(e){
            e.preventDefault();
            var el_id = event.target.id;
            var row_no = el_id.substr(6, );
            var trID = 'set'+ row_no;
            $('#'+trID).remove();
            $('.item_total').trigger('change');
            $('#items tr').length > 2 ? $("#summery").show() : $('#total').prop('value','') && $("#summery").hide();
            //console.log($('#items tr').length);

        });
        
        /*
         * Subtotal on change of:
         * quantity. 
         */
        $('.qty').keyup(function(e){
            e.preventDefault();
            var el_id = event.target.id;
            var row_no = el_id.substr(10, );
            $('#item_total'+row_no).prop('value', subTotal(row_no));
            $('.item_total').trigger('change');
        });
        
        /*
         * Subtotal on change of:
         * unit price. 
         */
        $('.unit_price').keyup(function(e){
            e.preventDefault();
            var el_id = event.target.id;
            var row_no = el_id.substr(10, );
            $('#item_total'+row_no).prop('value', subTotal(row_no)); 
            $('.item_total').trigger('change');
        });
        
        /*
         * Invoice Total
         */
        $('#items').find('.item_total').on('change', function(){
            var sum =0;
            $('.item_total').each(function(){
                sum = +sum + +$(this).val();
            });
            $('#total').prop('value',sum);
        });
        
    }); //#add-row
    
        
    
    
    
    
}); //doc ready

</script>

@stop