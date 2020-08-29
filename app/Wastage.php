<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wastage extends Model
{
    //set mass assignment
    protected $fillable = [
        'wastage_no',
        'wastage_date', 
        'wasted_at',
        'store_id', 
        'store_name',
        'quantity_type', 
        'issued_by',
        'is_approved',
        'report',
        'approved_by'
    ];
    
    /*
     * Relation setup:
     * Polimorphic Many to Many  using Productable.
     */
    public function stock() {
        return $this->morphToMany('App\Product', 'productable')
                ->withTimeStamps()
                ->withPivot([ 'quantity','store_id','flag']);
    }
    
    
}
