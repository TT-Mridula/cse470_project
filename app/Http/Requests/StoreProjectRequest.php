<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        // since your routes already have auth+admin middleware, this can simply be:
        return true;

        // or stricter:
        // return auth()->check() && auth()->user()->is_admin;
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:200'],
            'slug' => ['nullable','alpha_dash','max:220','unique:projects,slug'],
            'category' => ['nullable','string','max:100'],
            'image' => ['nullable','image','max:4096'],
            'short_description' => ['nullable','string','max:500'],
            'long_description' => ['nullable','string'],
            'github_url' => ['nullable','url'],
            'live_url' => ['nullable','url'],
            'extra_links' => ['nullable','array'],
            'extra_links.*' => ['url'],
            'is_published' => ['boolean'],
            'tech' => ['nullable','array'],
            'tech.*' => ['string','max:50'],
        ];
    }
}
