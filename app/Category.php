<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //set up mass assign fields.
    protected $fillable = ['name','description'];
}
