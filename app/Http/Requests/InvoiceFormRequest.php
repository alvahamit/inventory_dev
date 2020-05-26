<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceFormRequest extends FormRequest
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
        $this->method() == 'PATCH' ? $invoice_no_rules = 'required' : $invoice_no_rules = 'required|unique:invoices' ;
        
        $rules = [
            'invoice_date' => 'required',
            'invoice_no' => $invoice_no_rules,
            'invoice_type' => 'required|in:"1","2"',
            'total' => 'required',
        ];
        
        foreach($this->request->get('item_id') as $key => $val)
        {
            $rules['item_qty.'.$key] = 'required|min:1|not_in:"0"|lte:invoicable_qty.'.$key;
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
            'invoice_type.in' => 'Please select a type for invoice.',
        ];
          foreach($this->request->get('item_id') as $key => $val)
          {
            $messages['item_qty.'.$key.'.lte'] = 'Maximum invoiceable qty. for  <strong>'.$this->item_name[$key].', '.$this->item_unit[$key].'</strong> is <strong>'.$this->invoicable_qty[$key].'</strong> '.$this->q_type;
            $messages['item_qty.'.$key.'.not_in'] = $this->item_name[$key].' quantity cannot be <strong>0</strong>';
          }
          return $messages;
    }
    
    
}
