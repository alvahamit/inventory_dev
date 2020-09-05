<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /*
    * Defining Many to Many with Product and Country:
    */
    public function products() {
        return $this->belongsToMany('App\Product','country_product');
    }
}
