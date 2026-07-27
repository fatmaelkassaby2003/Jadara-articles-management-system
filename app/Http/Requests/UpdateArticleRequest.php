<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('article'));
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'sometimes|required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'sometimes|required|in:draft,published',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];
    }
}
