<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermission extends FormRequest
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
            'name' => 'required|max:50|min:3',
            'guard_name' => 'required|max:50|min:3',
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
            'name.max' => 'Name must be less than 50 character.',
            'name.min' => 'Name must be atleast 3 character long.',
            'guard_name.required' => 'Guard Name is required.',
            'guard_name.max' => 'Guard Name must be less than 50 character.',
            'guard_name.min' => 'Guard Name must be atleast 3 character long.'
        ];
    }
}
