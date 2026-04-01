<?php

namespace App\DTOs\Profile;

use App\Http\Requests\Profile\UpdatePatientProfileRequest;
use Illuminate\Http\UploadedFile;

class UpdatePatientProfileDTO {
    public function __construct(
        public ?string $firstName,
        public ?string $lastName,
        public ?string $phone,
        public ?UploadedFile $avatar,
        public ?string $dateOfBirth,
        public ?string $gender,
        public ?string $bloodType,
        public ?string $address,
        public ?string $emergencyContactName,
        public ?string $emergencyContactPhone,
    ) {}

    public static function fromRequest(UpdatePatientProfileRequest $request): self {
        $data = $request->validated();

        return new self(
            firstName: $data['firstName'] ?? null,
            lastName: $data['lastName'] ?? null,
            phone: $data['phone'] ?? null,
            avatar: $request->file('avatar'),
            dateOfBirth: $data['dateOfBirth'] ?? null,
            gender: $data['gender'] ?? null,
            bloodType: $data['bloodType'] ?? null,
            address: $data['address'] ?? null,
            emergencyContactName: $data['emergencyContactName'] ?? null,
            emergencyContactPhone: $data['emergencyContactPhone'] ?? null,
        );
    }
}