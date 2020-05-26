<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['label','organization','country_code','address','area','state','city','postal_code','latitude','longitude' ];
    
    protected $touches = ['users'];

    
    /*
     * Relation setup:
     * Polymorphic many to many.
     * Also return additional columns in Pivot table.
     */
    public function addresses() {
        return $this->morphToMany('App\Address', 'addressable')
                    ->withPivot('is_primary','is_billing','is_shipping');
    }

    
    /**
     * Defining The Inverse Of The Relationship.
     * Get all of the users that are assigned this address.
     */
    public function users()
    {
        return $this->morphedByMany('App\User', 'addressable')
                ->withPivot('is_primary','is_billing','is_shipping');
    }
    

}
