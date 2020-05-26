<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    //
    protected $fillable = ['unit', 'short', 'used_for'];
    
    //kg to gm
    public function gm($param){
        return $param*1000;
    }
    
    //gm to kg
    public function kg($param) {
        return $param/1000;
    }
    
    //ltr to ml
    public function ml($param) {
        return $param*1000;
    }
    
    //ml to ltr
    public function ltr($param) {
        return $param/1000;
    }
    
    /*
     * Relation setup:
     * One to Many with "packings" table.
     */
    public function packings() {
        return $this->hasMany('App\Packing');
    }
    
    
}
