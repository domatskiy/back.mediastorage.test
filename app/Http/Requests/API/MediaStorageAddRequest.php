<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class MediaStorageAddRequest extends FormRequest
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
            'name' => 'max:50',
            'email' => 'max:50',
            'file' => 'required|min:100000|max:150000'
        ];
    }

    public function authorize()
    {
        return false;
    }
}