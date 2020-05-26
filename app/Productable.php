<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productable extends Model
{
    //mass assign setting:
    protected $fillable = ['productable_type', 'productable_id', 'product_id', 'quantity', 'store_id', 'flag'];
    
    //Relation:
    //Polimorphic relation
    public function productable() {
        $this->morphTo();
    }
    
    //One to Many relation with Product 
    public function products() {
        $this->belongsToMany('App\Product');
    }
    
}
