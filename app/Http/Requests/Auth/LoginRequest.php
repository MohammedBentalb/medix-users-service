<?php

namespace App\Http\Requests\Auth;

use App\Enums\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class LoginRequest extends FormRequest {
    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
            'type' => ['required', 'string', new Enum(UserTypeEnum::class)],
        ];
    }
}
