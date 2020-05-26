<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseFormRequest extends FormRequest
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
            $ref_no_rules = 'required'; 
        } else {
            $ref_no_rules = 'required|unique:purchases'; 
        }
        
        return [
            //Required
            'ref_no' => $ref_no_rules,
            'receive_date' => 'required',
            'user_id' => 'required|exists:users,id',
            'purchase_type' => 'required',
            
            'product_ids'=> 'required|array|min:1',
            'product_ids.*'=> 'required',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required',
            'unit_prices' => 'required|array|min:1',
            'unit_prices.*' => 'required',
            'item_totals' => 'required|array|min:1',
            'item_totals.*' => 'required',
            
        ];
    }
    
    
    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages()
   {
       return [
           'ref_no.required' => 'Purchase reference number is missing.',
           'user_id.required' => 'Please select your supplier.',
           'product_ids.required'  => 'You must select at least one product.',
           'product_ids.*'=> 'Please choose a product from list.',
           'quantities.*' => 'Please specify product quantity.',
           'unit_prices.*' => 'Please specify product price.',
           'item_totals.*' => 'Item total cannot be empty.',
       ];
   }
    
}
