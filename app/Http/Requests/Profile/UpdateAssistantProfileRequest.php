<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateAssistantProfileRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'firstName' => ['sometimes', 'string', 'max:100'],
            'lastName'  => ['sometimes', 'string', 'max:100'],
            'phone'  => ['sometimes', 'nullable', 'string', 'max:20'],
            'avatar' => ['sometimes', 'nullable', 'image', File::types(['jgp', 'jpeg', 'png', 'webp']) , 'max:2048'],
        ];
    }
}
