<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'            => ['required', 'email', 'max:180', Rule::unique('users', 'email')],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
            'firstName'       => ['required', 'string', 'max:100'],
            'lastName'        => ['required', 'string', 'max:100'],
            'speciality'      => ['required', 'string', 'max:100'],
            'nationalId'      => ['nullable', 'string', 'max:50', Rule::unique('users', 'national_id')],
            'licenseNumber'   => ['required', 'string', 'max:100', Rule::unique('doctor_profiles', 'license_number')],
            'yearsExperience' => ['required', 'integer', 'min:0'],
            'consultationFee' => ['nullable', 'numeric', 'min:0'],
            'bio'             => ['nullable', 'string'],
            'avatar'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'phone'           => ['nullable', 'string', 'max:20'],
        ];
    }
}
