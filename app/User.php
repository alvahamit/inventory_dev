<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'organization'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /*
     * Defining user and role relationship.
     */
    public function role() {
        return $this->belongsToMany('App\Role');
    }
    
    /*
     * Relation setup:
     * One to Many with Order (with buyer role).
     */
    public function orders() {
        return $this->hasMany('App\Order');
    }
    
    /*
     * Relation setup:
     * One to Many with Invoices (with buyer role and customer_id).
     */
    public function invoices() {
        return $this->hasMany('App\Invoice','customer_id','id');
    }
    
    /*
     * Relation setup:
     * One to Many with Purchase (with supplier role).
     */
    public function purchases() {
        return $this->hasMany('App\Purchase');
    }
    
    /*
     * Relation setup:
     * One to Many with MoneyReceipt (with customer_id column).
     */
    public function mrs() {
        return $this->hasMany('App\MoneyReceipt','customer_id','id');
    }
    
    /*
     * Relation setup:
     * Polymorphic many to many.
     * Also return additional columns in Pivot table.
     */
    public function addresses() {
        return $this->morphToMany('App\Address', 'addressable')
                    ->withPivot('is_primary','is_billing','is_shipping');
    }
    /*
     * Relation setup:
     * Polymorphic many to many.
     * Also return additional columns in Pivot table.
     */
    public function contacts() {
        return $this->morphToMany('App\Contact', 'contactable')
                    ->withPivot('is_primary','is_billing','is_shipping');
    }
    
    /*
     * Accessor for created_at:
     */
//    public function getCreatedAtColumn($param) {
//        return diffForHumans($param);
//    }
    
    
}
