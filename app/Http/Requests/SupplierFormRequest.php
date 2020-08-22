<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierFormRequest extends FormRequest
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
            $email_rules = 'required|email'; 
        } else {
            $email_rules = 'required|email|unique:users'; 
        }
        
        $rules = [
            //General fields:
            'name' => 'required',
            'email' => $email_rules,
            'roles' => 'required|exists:roles,id',
            'address_label' => 'required',
            'organization' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'country_code' => 'required',
            'password' => 'nullable|confirmed',
            //Array fields:
            'contact_label'=> 'required|array|min:1',
            'contact_label.*'=> 'required',
            'country_code_contact' => 'required|array|min:1',
            'country_code_contact.*' => 'required',
            'number' => 'required|array|min:1',
            'number.*' => 'required',
        ];
        return $rules;
    }
    
    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages()
   {
       return [
           'address_label.required' => 'Please choose a label for address.',
           'contact_label.required' => 'Must add at least one contact.',
           'contact_label.*'=> 'Please choose a label for contact.',
           'country_code.required' => 'Please select a country.',
           'country_code_contact.*'=> 'Contact no country code is required',
           'number.*' => 'Contact number is required.',
       ];
   }
   
}
