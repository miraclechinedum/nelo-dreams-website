<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MediaItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'in_gallery' => $this->boolean('in_gallery'),
            'sort_order' => (int) $this->input('sort_order', 0),
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        // On create the file is required; on edit, keeping the existing file is fine.
        $creating = $this->routeIs('admin.media.store');

        return [
            'type' => ['required', Rule::in(['image', 'video'])],
            'file' => [
                $creating ? 'required' : 'nullable',
                'file',
                $this->input('type') === 'video'
                    ? 'mimes:mp4,mov,webm,m4v'
                    : 'mimes:jpg,jpeg,png,webp,gif',
                'max:'.($this->input('type') === 'video' ? 128 * 1024 : 8 * 1024),
            ],
            'poster' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:'.(8 * 1024)],
            'title' => ['nullable', 'string', 'max:160'],
            'caption' => ['nullable', 'string', 'max:400'],
            'category' => ['nullable', 'string', 'max:80'],
            'span' => ['required', Rule::in(['normal', 'wide', 'tall'])],
            'post_id' => ['nullable', 'exists:posts,id'],
            'in_gallery' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return ['file' => 'photo or video'];
    }
}
