<?php

namespace App\DTOs\Profile;

use App\Http\Requests\Profile\ChangePasswordRequest;

readonly class ChangePasswordDTO {
    public function __construct(
        public string $currentPassword,
        public string $newPassword,
    ) {}

    public static function fromRequest(ChangePasswordRequest $request): self {
        return new self(
            currentPassword: $request->validated('currentPassword'),
            newPassword:     $request->validated('newPassword'),
        );
    }
}