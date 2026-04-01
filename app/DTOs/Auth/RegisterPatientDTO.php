<?php

namespace App\DTOs\Auth;

use App\Http\Requests\Auth\RegisterPatientRequest;
use Illuminate\Http\UploadedFile;

readonly class RegisterPatientDTO {
    public function __construct(
        public string $email,
        public string $password,
        public string $firstName,
        public string $lastName,
        public ?UploadedFile $avatar,
        public string $dateOfBirth,
        public string $gender,
        public ?string $bloodType,
        public ?string $nationalId,
        public ?string $phone,
        public ?string $address,
        public ?string $emergencyContactName,
        public ?string $emergencyContactPhone,
    ) {}

    public static function fromRequest(RegisterPatientRequest $request): self {
        $data = $request->validated();

        return new self(
            email: $data['email'],
            password: $data['password'],
            firstName: $data['firstName'],
            lastName: $data['lastName'],
            avatar: $request->file('avatar'),
            dateOfBirth: $data['dateOfBirth'],
            gender: $data['gender'],
            bloodType: $data['bloodType'] ?? null,
            nationalId: $data['nationalId'] ?? null,
            phone: $data['phone'] ?? null,
            address: $data['address'] ?? null,
            emergencyContactName: $data['emergencyContactName'] ?? null,
            emergencyContactPhone: $data['emergencyContactPhone'] ?? null,
        );
    }
}
