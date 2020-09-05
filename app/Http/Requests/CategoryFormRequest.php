<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryFormRequest extends FormRequest
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
        $this->method() == 'PATCH' ? $nameRule = 'required|string' : $nameRule = 'required|string|unique:categories' ;
        // Check Create or Update
        if ($this->method() == 'PATCH'){
            $nameRule = ['required', 'string', 'max:255', Rule::unique('App\Category', 'name')->ignore($this->id)] ;
        } else {
            $nameRule = ['required', 'string', 'max:255', 'unique:App\Category,name'];
        }
        //Check if root category:
        if($this->has('root')){
            $catIdRule = 'nullable';
        } else {
            $catIdRule = 'required|integer';
        }
        return [
            'category_id' => $catIdRule,
            'name' => $nameRule,
            'description' => 'nullable|string', 
            
        ];
    }
    
    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages() 
    {
        $messages = [
            'category_id.required' => 'Please select a parent for your new category.',
        ];
        return $messages;
    }
}
