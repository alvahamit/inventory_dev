<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MoneyReceipt extends Model
{
    //set mass assignment
    protected $fillable = 
        [
            'mr_date',
            'mr_no',
            'customer_id',
            'customer_name',
            'customer_company',
            'customer_address',
            'customer_phone',
            'customer_email',
            'amount',
            'pay_mode',
            'cheque_no',
            'bank_name',
            'bkash_tr_no',
        ];
    
    /*
     * Accessor for date:
     */
    public function getMrDateAttribute($param) {
        return Carbon::create($param)->toFormattedDateString();
    }
    
    /*
     * Defining User and MoneyReceipt One to One inverse relationship.
     */
    public function customer() {
        return $this->belongsTo('App\User', 'customer_id', 'id');
    }
    
}
