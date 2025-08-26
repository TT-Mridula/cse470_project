<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkillRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'skill_category_id' => ['required','exists:skill_categories,id'],
            'name' => ['required','string','max:120'],
            'level' => ['required','integer','min:0','max:100'],
            'icon_class' => ['nullable','string','max:80'],
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable','integer','min:0','max:65535'],
        ];
    }
}
