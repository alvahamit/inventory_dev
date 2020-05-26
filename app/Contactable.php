<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactable extends Model
{
    //mass assign setting:
    protected $fillable = ['contactable_type', 'contactable_id', 'contact_id', 'is_primary', 'is_billing', 'is_shipping'];
    
    /*
     * Relationships:
     */
    public function contactable() {
        return $this->morphTo();
    }
}
