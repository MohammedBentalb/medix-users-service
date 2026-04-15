<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateDoctorProfileRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'firstName' => ['sometimes', 'string', 'max:100'],
            'lastName' => ['sometimes', 'string', 'max:100'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'avatar' => ['sometimes', 'nullable', 'image', File::types(['jpg', 'jpeg', 'png', 'webp']) , 'max:2048'],
            'speciality' => ['sometimes', 'string', 'max:100'],
            'licenseNumber' => ['sometimes', 'string', 'max:100', Rule::unique('doctor_profiles', 'license_number')->ignore($this->header('X-User-Id'), 'user_id')],
            'yearsExperience' => ['sometimes', 'integer', 'min:0'],
            'consultationFee' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'bio' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
