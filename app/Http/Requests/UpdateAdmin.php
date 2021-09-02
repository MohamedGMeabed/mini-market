<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
class UpdateAdmin extends FormRequest
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
        return [
            'name' => 'required|max:255|string',
            'email' => 'required|email', 
           //'email' => 'required|email|unique:admins,email,admin_id', 
            'password' =>'required|string|min:6',
           // 'admin_id'=>"required|exists:admins,id",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name Field is Required.',
            'name.string' => 'Name Field Must Be String.',
            'email.required' => 'Email Field Is Required.',
            'password.required' => 'Password Field is Required.',
            'password' => 'min type 6 char',
        ];
    }
}
