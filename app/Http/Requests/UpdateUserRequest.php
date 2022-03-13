<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->can('update', $this->user);
    }

    public function rules()
    {
        return [
            'name' => 'required|min:5|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user)],
            'password' => 'required|min:8',
            'profile_picture' => 'nullable|image'
        ];
    }
}
