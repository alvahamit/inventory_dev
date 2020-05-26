<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChallanFormRequest extends FormRequest
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
        $this->method() == 'PATCH' ? $challan_no_rules = 'required' : $challan_no_rules = 'required|unique:challans' ;
        $rules = [
            'challan_date' => 'required|date',
            'challan_no' => $challan_no_rules,
            'challan_type' => 'required|in:"1","2"',
            'item_id' => 'required',
        ];
        if($this->request->get('challan_type') == 1){
            $rules['supply_store'] = 'required|not_in:"0"';
            $rules['delivery_to'] = 'required';
            //$rules['customer_id'] = 'required';
            $rules['order_id'] = 'required';
            $rules['order_no'] = 'required|string';
        }
        if($this->request->get('challan_type') == 2){
            $rules['to_store'] = 'required|not_in:"0"';
        }
        if(count($this->request->get('item_id')) > 0){
            foreach($this->request->get('item_id') as $key => $val)
            {
                //$rules['item_qty.'.$key] = 'required|not_in:"0"|lte:invoicable_qty.'.$key;
                $rules['item_qty.'.$key] = 'required|integer|min:1|lte:invoicable_qty.'.$key;
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
            'challan_type.in' => 'Please select a type for challan.',
            'item_id.required' => 'No items selected for transfer.'
        ];
        if(count($this->request->get('item_id')) > 0){
            foreach($this->request->get('item_id') as $key => $val)
            {
              $messages['item_qty.'.$key.'.lte'] = 'Maximum challan qty. of  <strong>'.$this->item_name[$key].', '.$this->item_unit[$key].'</strong> for this order is <strong>'.$this->invoicable_qty[$key].'</strong> '.$this->q_type;
              $messages['item_qty.'.$key.'.not_in'] = $this->item_name[$key].' quantity cannot be <strong>0</strong>';
              $messages['supply_store.not_in'] = 'Please select a supply store.';
              $messages['to_store.not_in'] = 'Please select a store to move stock.';
              $messages['item_qty.'.$key.'.min'] = $this->item_name[$key].' quantity must be <strong>1</strong> or more.';
            }
        }
          
          return $messages;
    }
    
}
