<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkillCategoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'name' => ['required','string','max:120'],
            'slug' => ['nullable','alpha_dash','max:160','unique:skill_categories,slug'],
            'sort_order' => ['nullable','integer','min:0','max:65535'],
        ];
    }
}
