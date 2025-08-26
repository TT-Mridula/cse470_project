<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        // routes already have auth + admin middleware
        return true;
    }

    public function rules(): array
    {
        // with route model binding, this is a Project model
        $id = $this->route('project')->id ?? null;

        return [
            'title' => ['required','string','max:200'],
            'slug'  => [
                'nullable','alpha_dash','max:220',
                Rule::unique('projects','slug')->ignore($id),
            ],
            'category'          => ['nullable','string','max:100'],
            'image'             => ['nullable','image','max:4096'],
            'short_description' => ['nullable','string','max:500'],
            'long_description'  => ['nullable','string'],
            'github_url'        => ['nullable','url'],
            'live_url'          => ['nullable','url'],
            'extra_links'       => ['nullable','array'],
            'extra_links.*'     => ['url'],
            'is_published'      => ['boolean'],
            'tech'              => ['nullable','array'],
            'tech.*'            => ['string','max:50'],
        ];
    }
}
