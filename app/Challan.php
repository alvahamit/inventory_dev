<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Challan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'challan_date',
        'challan_no',
        'challan_type',
        'order_id',
        'order_no',
        'quantity_type',
        'store_id',
        'store_name',
        'store_address',
        'to_store_id', 
        'to_store_name', 
        'to_store_address', 
        'customer_id',
        'customer_name',
        'delivery_address',
        'issued_by'
    ];
    
    /*
     * Relation setup:
     * One to Many (Inverse) with Order.
     */
    public function order() {
        return $this->belongsTo('App\Order');
    }
    
    /*
     * Relation setup:
     * One to Many with Product (via pivot).
     */
    public function products() {
        return $this->belongsToMany('App\Product','challan_product', 'challan_id', 'product_id')
                ->withPivot('item_name', 'item_unit', 'quantity'); //additional fields to the pivot table
    }
    
    /*
     * Relation setup:
     * Polimorphic Many to Many  using Productable.
     */
    public function stock() {
        return $this->morphToMany('App\Product', 'productable');
    }
    
    /*
     * Accessor for date:
     */
    public function getChallanDateAttribute($param) {
        return Carbon::create($param)->toFormattedDateString();
    }
    /*
     * Accessor for order no:
     */
    public function getChallanNoAttribute($param) {
        return strtoupper($param);
    }
    
    
    
}
