<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdatePatientProfileRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'firstName' => ['sometimes', 'string', 'max:100'],
            'lastName' => ['sometimes', 'string', 'max:100'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'avatar' => ['sometimes', 'nullable', 'image', File::types(['jpg', 'jpeg', 'png', 'webp']) , 'max:2048'],
            'dateOfBirth' => ['sometimes', 'date'],
            'gender' => ['sometimes', 'string', 'in:male,female'],
            'bloodType' => ['sometimes', 'nullable', 'string', 'max:5'],
            'nationalId' => ['sometimes', 'nullable', 'string', 'max:50', Rule::unique('users', 'national_id')->ignore($this->header('X-User-Id'))],
            'address' => ['sometimes', 'nullable', 'string'],
            'emergencyContactName' => ['sometimes', 'nullable', 'string', 'max:200'],
            'emergencyContactPhone' => ['sometimes', 'nullable', 'string', 'max:20'],
        ];
    }
}