<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Fill in the slug from the title so the person writing the post never
     * has to think about URLs.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: $this->input('title')),
            'sort_order' => (int) $this->input('sort_order', 0),
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $postId = $this->route('post')?->id;

        return [
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'string', 'max:200', Rule::unique('posts', 'slug')->ignore($postId)],
            'category' => ['nullable', 'string', 'max:80'],
            'location' => ['nullable', 'string', 'max:180'],
            'period' => ['nullable', 'string', 'max:80'],
            'happened_on' => ['nullable', 'date'],
            'summary' => ['required', 'string', 'max:600'],
            'body' => ['nullable', 'string', 'max:20000'],
            'hashtags' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['boolean'],

            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:'.$this->imageKb()],
            'media' => ['nullable', 'array', 'max:20'],
            'media.*' => ['file', 'mimes:jpg,jpeg,png,webp,gif,mp4,mov,webm,m4v', 'max:'.$this->videoKb()],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'media.*.max' => 'Each file must be under '.round($this->videoKb() / 1024).'MB.',
            'media.*.mimes' => 'Photos must be JPG, PNG, WEBP or GIF; videos must be MP4, MOV, WEBM or M4V.',
        ];
    }

    private function imageKb(): int
    {
        return 8 * 1024;
    }

    private function videoKb(): int
    {
        return 128 * 1024;
    }
}
