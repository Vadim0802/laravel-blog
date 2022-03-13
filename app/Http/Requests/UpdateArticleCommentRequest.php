<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleCommentRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->can('update', $this->comment);
    }

    public function rules()
    {
        return [
            'content' => 'required|max:255'
        ];
    }
}
