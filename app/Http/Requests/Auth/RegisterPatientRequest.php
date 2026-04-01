<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterPatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'                   => ['required', 'email', 'max:180', Rule::unique('users', 'email')],
            'password'                => ['required', 'string', 'min:8', 'confirmed'],
            'firstName'             => ['required', 'string', 'max:100'],
            'lastName'              => ['required', 'string', 'max:100'],
            'dateOfBirth'           => ['required', 'date'],
            'gender'                => ['required', 'string', 'in:male,female'],
            'bloodType'             => ['nullable', 'string', 'max:5'],
            'nationalId'            => ['nullable', 'string', 'max:50', Rule::unique('users','national_id')],
            'avatar'                => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'phone'                 => ['nullable', 'string', 'max:20'],
            'address'               => ['nullable', 'string'],
            'emergencyContactName'  => ['nullable', 'string', 'max:200'],
            'emergencyContactPhone' => ['nullable', 'string', 'max:20'],
        ];
    }
}
