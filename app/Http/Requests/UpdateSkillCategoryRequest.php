<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSkillCategoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        $id = $this->route('skill_category')->id ?? null;
        return [
            'name' => ['required','string','max:120'],
            'slug' => ['nullable','alpha_dash','max:160', Rule::unique('skill_categories','slug')->ignore($id)],
            'sort_order' => ['nullable','integer','min:0','max:65535'],
        ];
    }
}
