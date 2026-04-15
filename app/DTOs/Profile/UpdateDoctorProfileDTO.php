<?php

namespace App\DTOs\Profile;

use App\Http\Requests\Profile\UpdateDoctorProfileRequest;
use Illuminate\Http\UploadedFile;

class UpdateDoctorProfileDTO {
    public function __construct(
        public ?string $firstName,
        public ?string $lastName,
        public ?string $phone,
        public ?UploadedFile $avatar,
        public ?string $speciality,
        public ?string $licenseNumber,
        public ?int $yearsExperience,
        public ?float $consultationFee,
        public ?string $bio,
    ) {}

    public static function fromRequest(UpdateDoctorProfileRequest $request): self {
        $data = $request->validated();

        return new self(
            firstName: $data['firstName'] ?? null,
            lastName: $data['lastName'] ?? null,
            phone: $data['phone'] ?? null,
            avatar: $request->file('avatar'),
            speciality: $data['speciality'] ?? null,
            licenseNumber: $data['licenseNumber'] ?? null,
            yearsExperience: $data['yearsExperience'] ?? null,
            consultationFee: $data['consultationFee'] ?? null,
            bio: $data['bio'] ?? null,
        );
    }
}