<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MediaStorageEditRequest extends FormRequest
{
    public function messages()
    {
        return [
            'required'    => 'The :attribute required',
            'size'    => 'The :attribute must be exactly :size.',
        ];
    }

    public function rules()
    {
        return [
            'email' => 'nullable|email|max:50',
            'file' => 'required|min:100000|max:150000',
            'description' => 'nullable|max:250'
            ];
    }

    public function authorize()
    {
        return false;
    }
}