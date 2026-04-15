<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignRolesRequest extends FormRequest {
    public function rules(): array {
        return [
            'roles'   => ['required', 'array'],
            'roles.*' => ['string', Rule::exists('roles', 'name')],
        ];
    }
}