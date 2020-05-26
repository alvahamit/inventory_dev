<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addressable extends Model
{
    //mass assign setting:
    protected $fillable = ['addressable_type', 'addressable_id', 'address_id', 'is_primary', 'is_billing', 'is_shipping'];
    
    /*
     * Relationships:
     */
    public function addressable() {
        return $this->morphTo();
    }
    

    
}
