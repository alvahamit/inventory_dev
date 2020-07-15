<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Check Create or Update
        if ($this->method() == 'PATCH'){
            $order_no_rules = 'required'; 
        } else {
            $order_no_rules = 'required|unique:orders'; 
        }
        
        if($this->has('user_id')){
            return [
                //General fields:
                'order_no' => $order_no_rules,
                'order_date' => 'required',
                'user_id' => 'required|exists:users,id',
                'select_customer_company' => 'required',
                'select_customer_address' => 'required',
                'select_customer_contact' => 'required',
                'customer_name_shipping' => 'required',
                'shipping_company' => 'required',
                'shipping_address' => 'required',
                'shipping_contact' => 'required',
                //Array fields:
                'product_ids'=> 'required|array|min:1',
                'product_ids.*'=> 'required',
                'quantities' => 'required|array|min:1',
                'quantities.*' => 'required|not_in:0',
                'unit_prices' => 'required|array|min:1',
                'unit_prices.*' => 'required',
                'item_totals' => 'required|array|min:1',
                'item_totals.*' => 'required',
                //Last field
                'total' => 'required',
            ];
        } else {
            return [
                //General fields:
                'order_no' => $order_no_rules,
                'order_date' => 'required',
                'customer_name' => 'required',
                'customer_company' => 'required',
                'customer_address' => 'required',
                'contact_no' => 'required',
                'customer_name_shipping' => 'required',
                'shipping_company' => 'required',
                'shipping_address' => 'required',
                'shipping_contact' => 'required',
                //Array fields:
                'product_ids'=> 'required|array|min:1',
                'product_ids.*'=> 'required',
                'quantities' => 'required|array|min:1',
                'quantities.*' => 'required|not_in:0',
                'unit_prices' => 'required|array|min:1',
                'unit_prices.*' => 'required',
                'item_totals' => 'required|array|min:1',
                'item_totals.*' => 'required',
                //Last field:
                'total' => 'required',
            ];
        }
        
        
    }
    
    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages()
   {
       return [
           'order_no.required' => 'Order number is missing.',
           'user_id.required' => 'Please select your customer.',
           'select_customer_company.required' => 'Customer company is required.',
           'select_customer_address.required' => 'Customer address is required.',
           'select_customer_contact.required' => 'A contact number is required.',
           'customer_contact.required' => 'A customer contact number is required.',
           'customer_name_shipping.required' => 'Name required for shipping.',
           'shipping_company.required' => 'Company name required for shipping.',
           'shipping_contact.required' => 'Shipping contact number is required.',
           'product_ids.required'  => 'You must select at least one product.',
           'product_ids.*'=> 'Please choose a product from list.',
           'quantities.*' => 'Please specify product quantity.',
           'unit_prices.*' => 'Please specify product price.',
           'item_totals.*' => 'Item total cannot be empty.',
       ];
   }
    
    
}
