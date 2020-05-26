<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invoice extends Model
{
    //set mass assignment
    protected $fillable = 
        [
            'invoice_date',
            'invoice_no',
            'order_id',
            'order_no',
            'quantity_type',
            'invoice_type',
            'invoiced_by',
            'customer_id',
            'billed_to',
            'discount',
            'carrying',
            'other_charge',
            'invoice_total',
        ];
    
    /*
     * Relation setup:
     * One to Many with Product (via pivot).
     */
    public function products() {
        return $this->belongsToMany('App\Product','invoice_product', 'invoice_id', 'product_id')
                ->withPivot('item_name', 'item_unit', 'unit_price', 'item_qty', 'item_total'); //additional fields to the pivot table
    }
    /*
     * Inverse One to Many relation with Order.
     */
    public function order() {
        return $this->belongsTo('App\Order');
    }
    
    /*
     * Accessor for date:
     */
    public function getInvoiceDateAttribute($param) {
        return Carbon::create($param)->toFormattedDateString();
    }
    /*
     * Accessor for order no:
     */
    public function getInvoiceNoAttribute($param) {
        return strtoupper($param);
    }
}
