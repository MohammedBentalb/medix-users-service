<?php

namespace App\DTOs\Auth;

use App\Http\Requests\Auth\RegisterAssistantRequest;
use Illuminate\Http\UploadedFile;

readonly class RegisterAssistantDTO {
    public function __construct(
        public string $email,
        public string $password,
        public string $firstName,
        public string $lastName,
        public ?UploadedFile $avatar,
        public ?string $nationalId,
        public ?string $phone,
    ) {}

    public static function fromRequest(RegisterAssistantRequest $request): self {
        $data = $request->validated();

        return new self(
            email: $data['email'],
            password: $data['password'],
            firstName: $data['firstName'],
            lastName: $data['lastName'],
            avatar: $request->file('avatar'),
            nationalId: $data['nationalId'] ?? null,
            phone: $data['phone'] ?? null,
        );
    }
}
