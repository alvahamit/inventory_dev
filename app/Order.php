<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Order extends Model
{
    //set mass assignment
    protected $fillable = 
        [
            'order_no',
            'order_date',
            'user_id',
            'customer_name',
            'customer_company',
            'customer_address',
            'customer_contact',
            'shipp_to_name',
            'shipp_to_company',
            'shipping_address',
            'shipping_contact',
            'quantity_type',
            'order_total',
            'is_invoiced',
            'order_status',
            'order_type',
        ];
    
    /*
     * Check if order is complete
     * Return true or false
     */
    public function isComplete(){
        $zeroQty = 0;
        if(count($this->challans) > 0){
            $challan_ids = $this->challans()->pluck('id')->toArray();
            $challan_issued = DB::table('challan_product')
                ->select('product_id', DB::raw('sum(quantity) as qty') )
                ->whereIn('challan_id', $challan_ids)
                ->groupBy('product_id')->get();
            foreach($this->products as $item) { 
                $challan_qty = $challan_issued->where('product_id', $item->pivot->product_id)->pluck('qty')->first();
                $zeroQty = ($item->pivot->quantity - $challan_qty) + $zeroQty; 
            }
            //return $zeroQty;
            return $zeroQty == 0 ? true : false;
        } else {
            return false;
        }
    }
    /*
     * Check if order is Invoiced
     * returns true or false
     */
    public function isInvoiced(){
        return count($this->invoices) > 0 ? true : false;
    }
    
    /*
     * Check if sales challan is issued.
     * returns true or false
     */
    public function issuedChallan(){
        return count($this->challans) > 0 ? true : false;
    }
    
    /*
     * Relation setup:
     * One to Many with Product (via pivot).
     */
    public function products() {
        return $this->belongsToMany('App\Product','order_product', 'order_id', 'product_id')
                ->withPivot('quantity', 'unit_price', 'item_total', 'product_name', 'product_packing'); //additional fields to the pivot table
    }
    /*
     * One to Many relation with Invoice.
     */
    public function invoices() {
        return $this->hasMany('App\Invoice');
    }
    
    
    /*
     * One to Many relation with Challan.
     */
    public function challans() {
        return $this->hasMany('App\Challan');
    }
    
    
    /*
     * Accessor for date:
     */
    public function getOrderDateAttribute($param) {
        return Carbon::create($param)->toFormattedDateString();
    }
    
    /*
     * Accessor for order no:
     */
    public function getOrderNoAttribute($param) {
        return strtoupper($param);
    }
    
}



