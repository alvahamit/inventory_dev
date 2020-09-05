<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //set up mass assign fields.
    protected $fillable = ['name','description', 'category_id'];
    
    
    /*
     * Relation Setup:
     * A simple hasMany() method, so category may have other subcategories:
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    /*
     * Recursive relationship:
     * So, if you call Category::with(‘categories’), it will get you one level of “children”, 
     * but Category::with(‘childrenCategories’) will give you as many levels as it could find.
     */
    public function childrenCategories()
    {
        return $this->hasMany(Category::class)->with('categories');
    }
    /*
    * Defining Many to Many with Product and Category:
    */
    public function products() {
        return $this->belongsToMany('App\Product','category_product');
    }
}
