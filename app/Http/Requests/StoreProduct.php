<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
            'title'  => 'required|string',
            'description'  => 'required|string',
            'price'  => 'required|numeric',
            'image'  => 'image',

        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Product title Required',
            'title.string' => 'Product title Must Be String',
            'description.required' => 'Product Description Required',
            'description.string' => 'Product Description Must Be String',
            'price.required' => 'Product Price Required',
            'price.numeric' => 'Product price Must Be Numeric',
        ];
    }
}
