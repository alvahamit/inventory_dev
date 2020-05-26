<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MrFormRequest extends FormRequest
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
        $this->method() == 'PATCH' ? $mr_no_rules = 'required|string' : $mr_no_rules = 'required|string|unique:money_receipts' ;
        // Check inputChooser for setting customer id rules:
        switch ($this->inputChooser) {
            case 1: //Type in Customer details.
                $customer_id_rules = 'nullable';
                break;
            case 2: //Choose from list.
                $customer_id_rules = 'required';
                break;
            default:
                $customer_id_rules = 'nullable';
        }
        // Check pay mode for setting rules:
        switch ($this->payModeChooser) {
            case 1: //Cash
                $chq_no_rule = 'nullable';
                $bnk_name_rule = 'nullable';
                $bkash_tr_rule = 'nullable';
              break;
            case 2: //Cheque
                $chq_no_rule = 'required|digits:6';
                $bnk_name_rule = 'required';
                $bkash_tr_rule = 'nullable';
              break;
            case 3: //bKash
                $chq_no_rule = 'nullable';
                $bnk_name_rule = 'nullable';
                $bkash_tr_rule = 'required|digits:10';
              break;
            default:
                $chq_no_rule = 'nullable';
                $bnk_name_rule = 'nullable';
                $bkash_tr_rule = 'nullable';
        }
        
        $rules = [
            'mr_no' => $mr_no_rules,
            'mr_date' => 'required|date',
            'customer_id' => $customer_id_rules,
            'customer_name' => 'required|string',
            'customer_company' => 'required',
            'customer_address' => 'required',
            'customer_phone' => 'required',
            'customer_email' => 'nullable|email',
            'amount' => 'required|numeric|min:1',
            //'pay_mode' => 'required',
            'bank_name' => $bnk_name_rule,
            'cheque_no' => $chq_no_rule,
            'bkash_tr_no' => $bkash_tr_rule,
        ];
        // For reference: $this->request->get('challan_type') == 1
        
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
            'mr_date.required' => 'Money receipt needs a date.',
            'mr_no.required' => 'Money receipt needs a reference number.',
            'mr_no.unique' => 'This reference number is already taken.',
            'customer_id.required' => 'Please selece a customer form list.',
            'bkash_tr_no.required' => 'bKash transaction number is required.',
            'bkash_tr_no.digits' => 'bKash transaction number should be 10 digits.',
        ];
        return $messages;
    }
    
    
}
