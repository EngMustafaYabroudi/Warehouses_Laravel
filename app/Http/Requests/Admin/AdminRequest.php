<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
    
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'type' => 'required',
            'role_id' => 'required',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $admin = $this->route()->parameter('administrator');
            $rules['email'] = 'required|email|unique:users,id,' . $admin->id;
            $rules['password'] = '';

        }//end of if

        return $rules;

    }//end of rules

    protected function prepareForValidation()
    {
        return $this->merge([
            'type' => 'administrator'
        ]);

    }//end of prepare for validation
}
