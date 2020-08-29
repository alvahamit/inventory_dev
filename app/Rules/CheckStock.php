<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Store;
use App\Product;

class CheckStock implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($store, $qty_type, $item_id)
    {
        //get the parameters in:
        $this->store_id = $store;
        $this->qty_type = $qty_type;
        $this->item_id = $item_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($this->store_id == 0){ 
            return false;
        } else {
            //Find Item or Product
            $item = Product::findOrFail($this->item_id);
            $stock = $item->itemStock($this->qty_type, $this->store_id);
            return $stock['qty'] >= $value ? true : false ;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if($this->store_id > 0){
            $store = Store::findOrFail($this->store_id);
            return 'Item quantity exceeded available stock at <strong>'.$store->name.'.' ;
        } else {
            return 'You have selected an invalid store.' ;
        }
    }
}
