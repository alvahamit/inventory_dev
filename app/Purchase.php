<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //set mass assignment
    protected $fillable = ['ref_no','receive_date', 'user_id', 'purchase_type', 'total'];
    
    /*
     * Relation setup:
     * One to Many with Product (via pivot).
     */
    public function products() {
        return $this->belongsToMany('App\Product','product_purchase', 'purchase_id', 'product_id')
                ->withPivot('quantity', 'unit_price', 'item_total', 'manufacture_date', 'expire_date'); //additional fields to the pivot table
    }
    /*
     * Relation setup:
     * One to Many with User (with role of Supplier).
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    /*
     * Relation setup:
     * many to Many Polimorphic using Stock.
     */
//    public function stock() {
//        return $this->morphToMany('App\Stock', 'stockable');
//    }
    
    /*
     * Relation setup:
     * Polimorphic Many to Many  using Productable.
     */
    public function stock() {
        //return $this->morphToMany('App\Stock', 'stockable', 'stocks', 'product_id', 'stockable_id', 'stockable_type');
        return $this->morphToMany('App\Product', 'productable')->withTimeStamps();
    }
    
}
