<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //set mass assignment
    protected $fillable = ['name','description'];

    /*
     * Defining user and role relationship.
     */
    public function users() {
        return $this->belongsToMany('App\User');
    }
}
