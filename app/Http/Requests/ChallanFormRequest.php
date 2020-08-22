<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckStock;
use Illuminate\Support\Arr;

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
        $store = $this->request->get('supply_store');
        $qty_type = $this->request->get('q_type');
        list($keys, $challan_types) = Arr::divide(config('constants.challan_type'));
        //General challan rules:
        $rules = [
            'challan_date' => 'required|date',
            'challan_no' => $challan_no_rules,
            //'challan_type' => 'required|in:"1","2"',
            'challan_type' => 'required|in:'.implode(',',$challan_types),
            'item_id' => 'required|array|min:1',
            'item_id.*' => 'required',
        ];
        //Challan type specific rules:
        $checkArray = [config('constants.challan_type.sales'), config('constants.challan_type.sample')];
        if( in_array($this->request->get('challan_type'), $checkArray) ){
            $rules['supply_store'] = 'required|not_in:"0"';
            $rules['delivery_to'] = 'required';
            $rules['order_id'] = 'required';
            $rules['order_no'] = 'required|string';
            //Challan item rules:
            if($this->request->has('item_id')){
                if(count($this->request->get('item_id')) > 0){
                    foreach($this->request->get('item_id') as $key => $val)
                    {
                        $item_id = $val;
                        $rules['item_qty.'.$key] = ['required', 'integer','min:1','lte:invoicable_qty.'.$key, new CheckStock($store, $qty_type, $item_id)];
                    }
                }
            }
        }
        //Challan type specific rules (transfer):
        if($this->request->get('challan_type') == config('constants.challan_type.transfer')){
            $rules['to_store'] = 'required|not_in:"0"';
            //Challan item rules:
            if($this->request->has('item_id')){
                if(count($this->request->get('item_id')) > 0){
                    foreach($this->request->get('item_id') as $key => $val)
                    {
                        $item_id = $val;
                        $rules['item_qty.'.$key] = ['required', 'integer','min:1','lte:invoicable_qty.'.$key];
                    }
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
            'challan_type.in' => 'Please select a type for challan.',
            'item_id.required' => 'No items selected for transfer.'
        ];
        if($this->request->has('item_id')){
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
        }
        
          
          return $messages;
    }
    
}
