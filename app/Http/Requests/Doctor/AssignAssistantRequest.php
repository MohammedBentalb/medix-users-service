<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class AssignAssistantRequest extends FormRequest {
    public function rules(): array {
        return ['assistantId' => ['required', 'string', 'uuid']];
    }
}
