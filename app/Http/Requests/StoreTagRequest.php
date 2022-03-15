<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 */
class StoreTagRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->is_admin;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3|unique:tags,name'
        ];
    }
}
