<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\Measurement;

class Product extends Model
{
    //set mass assignment
    protected $fillable = ['name','description'];
    
    /*
     * Relation setup:
     * One to One with Country.
     */
    public function country() {
        return $this->belongsTo('App\Country');
    }
    
    /*
     * Relation setup:
     * One to Many with Purchase (via pivot).
     */
    public function purchases() {
        return $this->belongsToMany('App\Purchase','product_purchase', 'purchase_id', 'product_id');
    }
    
    
    /*
     * Relation setup:
     * One to Many with Packing.
     */
    public function packings() {
        return $this->hasMany('App\Packing');
    }
    /*
     * Relation setup:
     * Belongs to Many with Measurement via pivot table 'packings'.
     */
    public function units() {
        return $this->belongsToMany('App\Measurement', 'packings');
    }
    /*
     * Relation setup:
     * One to Many with Stock/Productable.
     */
    public function stocks() {
        return $this->hasMany('App\Productable');
    }
    
    
    
    /*
     * Method to explain stock
     * Cmt: for total stock.
     * @returns $result[]
     */
    public function itemStock($inFormat = '', $storeId = '') {
        //Note: If store id is provided use id to get store specific stock otherwise get all stock:
        $storeId != '' ? $stocks = $this->stocks->where('store_id', $storeId) : $stocks = $this->stocks;
        $in = 0;
        $out = 0;
        //$result = [];
        foreach ($stocks as $stock){
            if($stock->flag == "in"){ $in = $in + $stock->quantity; }
            if($stock->flag == "out"){ $out = $out + $stock->quantity; }
        }
        $count = ($in - $out);
        /*
         * Prepare result as per user prefered format.
         */
        switch ($inFormat){
            case "weight":
                $qty = $this->packings()->first()->quantity * $this->packings()->first()->multiplier * $count;
                $price = round($this->packings()->first()->price/($this->packings()->first()->quantity * $this->packings()->first()->multiplier),2);
                //$unit = Measurement::findOrFail($this->packings()->first()->measurement_id)->unit;
                $unit = $this->units()->first()->short;
                $result = [
                    'unit' => $unit,
                    'qty' => $qty,
                    'price' => $price
                ];
                break;
            case "pcs":
                $qty = $this->packings()->first()->multiplier * $count;
                $price = round($this->packings()->first()->price/($this->packings()->first()->multiplier),2);
                $result = [
                    'unit' => 'pcs',
                    'qty' => $qty,
                    'price' => $price
                ];
                break;
            default:
                $unit = $this->packings()->first()->name;
                $price = round($this->packings()->first()->price, 2);
                $result = [
                    'unit' => $unit,
                    'qty' => $count,
                    'price' => $price
                ];          
        }
        return $result;
    }
    
    /*
     * Method to return item stock in percent for dash.
     * Cmt: for total stock.
     * @return $result percentage.
     */
    public function itemStockPercent(){
        $in = 0;
        $out = 0;
        $stocks = $this->stocks;
        foreach ($stocks as $stock){
            if($stock->flag == "in"){ $in = $in + $stock->quantity; }
            if($stock->flag == "out"){ $out = $out + $stock->quantity; }
        }
        $stockCount = ($in - $out);
        /*
         * Division by zero is undefined. Therefore with zero in-stock
         * this formula will give error. That is why ternerary if statement
         * is used to check in value.
         */
        $in != 0 ? $result=($stockCount/900)*100 : $result=0;
        return $result;
    }
   
    /*
     * This function convers product quantity from 
     * any formated qty to system friendly quantity.
     */
    public function productCountNormalizer($inFormat = '', $count){
        switch ($inFormat){
            case "weight":
                $qty = $count/($this->packings()->first()->quantity * $this->packings()->first()->multiplier);
                break;
            case "pcs":
                $qty = $count/$this->packings()->first()->multiplier;
                break;
            case "packing":
                $qty = $count;
                break;
            default:
                $qty = $count;        
        }
        return $qty;
    }
    
}
