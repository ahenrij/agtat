<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StructureCreateRequest extends Request
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
            'raison_sociale' => 'bail|required',
            'contact' => 'bail|required|max:20|unique:structures',
            'adresse' => 'bail|required'
        ];
    }
}
