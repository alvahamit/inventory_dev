<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\CheckStock;

class WastageFormRequest extends FormRequest
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
        if($this->method() == 'PATCH') { 
            $rule_ref_no = ['required', 'string', Rule::unique('App\Wastage', 'wastage_no')->ignore($this->id)] ;           
        } else {
            $rule_ref_no = ['required', 'string', 'unique:App\Wastage,wastage_no'] ;
        }
        $store = $this->request->get('store_id');
        $qty_type = $this->request->get('quantity_type');
        
        $rules = [
            //General fields:
            'wastage_no'=> $rule_ref_no,
            'wastage_date'=> 'required|date', 
            'wasted_at'=> 'required',
            'store_id'=> 'required', 
            'store_name'=> 'required',
            'quantity_type'=> 'required', 
            'issued_by'=> 'nullable',
            'is_approved'=> 'nullable|boolean',
            'report'=> 'required|string',
            'approved_by'=> 'nullable|string',
            //'product_ids' => 'required|array|min:1',
            //'product_ids.*' => 'required',
            //'quantities' => 'required|array|min:1',
            //'quantities.*' => 'required',
        ];
        
        if($this->request->has('product_ids')){
            if(count($this->request->get('product_ids')) > 0){
                foreach($this->request->get('product_ids') as $key => $val)
                {
                    $rules['product_ids.'.$key] = ['required', 'integer'];
                    $rules['quantities.'.$key] = ['required', 'numeric', new CheckStock($store, $qty_type, $val)];
                }
            }
        }
        return $rules;
    }
    
    
    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages() 
    {
        $messages = [
            'store_id.required' => 'Please select a <b>Store</b> accociated with this wastage.',
            'product_ids.required' => 'Please click on <b>+Add Row</b> button to add a product.',
            'product_ids.*.required' => 'Please select a <b>Product</b> from list.',
            'quantities.*.required' => 'Please type in wastage <b>quantity</b>.',
        ];
//        if($this->request->has('product_ids')){
//            if(count($this->request->get('product_ids')) > 0){
//                foreach($this->request->get('product_ids') as $key => $val)
//                {
//                  $messages['product_ids.'.$key.'.required'] = "Please select a <b>Product</b> from list.";
//                  $messages['quantities.'.$key.'.required'] = "Please type in wastage <b>quantity</b>.";
//                  $messages['quantities.'.$key.'.numeric'] = "Wastage <b>quantity</b> should be numeric.";
//                }
//            }
//        }
        return $messages;
    }
    
}
