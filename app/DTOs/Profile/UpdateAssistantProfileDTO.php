<?php

namespace App\DTOs\Profile;

use App\Http\Requests\Profile\UpdateAssistantProfileRequest;
use Illuminate\Http\UploadedFile;

class UpdateAssistantProfileDTO {
    public function __construct(
        public ?string $firstName,
        public ?string $lastName,
        public ?string $phone,
        public ?UploadedFile $avatar,
    ) {}

    public static function fromRequest(UpdateAssistantProfileRequest $request): self {
        $data = $request->validated();

        return new self(
            firstName: $data['firstName'] ?? null,
            lastName: $data['lastName'] ?? null,
            phone: $data['phone'] ?? null,
            avatar: $request->file('avatar'),
        );
    }
}
