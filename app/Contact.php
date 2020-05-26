<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['label','country_code','city_code','number' ];
    protected $touches = ['users'];
    
    /*
     * Relation setup:
     * Polymorphic many to many.
     * Also return additional columns in Pivot table.
     */
    public function contacts() {
        return $this->morphToMany('App\Contact', 'contactable')
                    ->withPivot('is_primary','is_billing','is_shipping');
    }
    
    
    /**
     * Defining The Inverse Of The Relationship.
     * Get all of the users that are assigned this address.
     */
    public function users()
    {
        return $this->morphedByMany('App\User', 'contactable')
                ->withPivot('is_primary','is_billing','is_shipping');
    }
    
    /*
     * Accessor for null fields:
     * Without this edit form gets 'null' text in places for null value.
     */
    public function getCityCodeAttribute($param) {
        return !empty($param) ? $param : '' ;
    }
    public function getCountryCodeAttribute($param) {
        return !empty($param) ? $param : '' ;
    }
    
}
