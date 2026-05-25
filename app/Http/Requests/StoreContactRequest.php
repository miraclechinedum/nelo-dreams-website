<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'interest' => ['nullable', 'string', 'in:Partner,Donate,Volunteer,General'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
            // Honeypot — must remain empty.
            'website' => ['nullable', 'size:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'message.min' => 'Please tell us a little more (at least 10 characters).',
            'website.size' => 'Spam detected.',
        ];
    }
}
