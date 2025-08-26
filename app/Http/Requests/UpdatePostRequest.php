<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array {
        return [
            'title'       => ['required','string','max:200'],
            'slug'        => ['nullable','alpha_dash','max:220', Rule::unique('posts','slug')->ignore($this->post->id ?? null)],
            'post_category_id' => ['nullable','exists:post_categories,id'],
            'excerpt'     => ['nullable','string','max:300'],
            'body'        => ['nullable','string'],
            'image'       => ['nullable','image','max:4096'],
            'is_published'=> ['boolean'],
        ];
    }
}

