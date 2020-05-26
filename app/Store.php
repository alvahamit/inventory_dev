<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
    protected $fillable = [
        'name',
        'address',
        'location',
        'contact_no'
    ];
    
    
    
    /*
     * Relation setup:
     * One to Many with Stock/Productable.
     */
    public function stocks() {
        return $this->hasMany('App\Productable');
    }
    
    
}
