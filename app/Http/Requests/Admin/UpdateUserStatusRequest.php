<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateUserStatusRequest extends FormRequest {
    public function rules(): array {
        return ['status' => ['required', new Enum(UserStatusEnum::class)] ];
    }
}