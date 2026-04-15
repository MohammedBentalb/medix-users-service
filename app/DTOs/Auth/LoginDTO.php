<?php

namespace App\DTOs\Auth;

use App\Http\Requests\Auth\LoginRequest;

readonly class LoginDTO {

    private function __construct(public string $email, public string $password) {}

    public static function fromRequest(LoginRequest $request): self {
        $data = $request->validated();
        return new self(
            email:    $data['email'],
            password: $data['password'],
        );
    }
}
