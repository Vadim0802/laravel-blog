<?php

namespace App\Http\Requests;

use App\Models\ArticleComment;
use Illuminate\Foundation\Http\FormRequest;
/**
 * @property string content
 */
class StoreArticleCommentRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->can('create', ArticleComment::class);
    }

    public function rules()
    {
        return [
            'content' => 'required|max:255'
        ];
    }
}
