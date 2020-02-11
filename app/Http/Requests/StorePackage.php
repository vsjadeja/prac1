<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackage extends FormRequest
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
            'name' => 'required|max:50|min:5',
            'description' => 'required|max:500',
            'price' => 'required',
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'package_type_id' => 'required',
            'status' => 'required',
        ];
    }

    /**
     * Get the validation message that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.max' => 'Name must be less than 50 character  .',
            'name.min' => 'Name must be atleast 5 character long.',
            'description.required' => 'Description is required.',
            'description.max' => 'Description length must be less than 500 character.',
            'price.required' => 'Price is required.',
            'thumb.mimes' => 'Uload only jpg and png image for thumb.',
            'thumb.max' => 'Uload < 2 MB sized thumb.',
            'package_type_id.required' => 'Package Type is required.',
            'status.required' => 'Status is required.',
        ];
    }
}
