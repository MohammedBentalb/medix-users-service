<?php

namespace App\DTOs\Auth;

use App\Http\Requests\Auth\RegisterDoctorRequest;
use Illuminate\Http\UploadedFile;

readonly class RegisterDoctorDTO {
    public function __construct(
        public string $email,
        public string $password,
        public string $firstName,
        public string $lastName,
        public ?UploadedFile $avatar,
        public ?string $nationalId,
        public string $speciality,
        public string $licenseNumber,
        public int $yearsExperience,
        public ?float $consultationFee,
        public ?string $bio,
        public ?string $phone,
    ) {}

    public static function fromRequest(RegisterDoctorRequest $request): self {
        $data = $request->validated();

        return new self(
            email: $data['email'],
            password: $data['password'],
            firstName: $data['firstName'],
            lastName: $data['lastName'],
            avatar: $request->file('image'),
            nationalId: $data['nationalId'] ?? null,
            speciality: $data['speciality'],
            licenseNumber: $data['licenseNumber'],
            yearsExperience: $data['yearsExperience'],
            consultationFee: $data['consultationFee'] ?? null,
            bio: $data['bio'] ?? null,
            phone: $data['phone'] ?? null,
        );
    }
}
