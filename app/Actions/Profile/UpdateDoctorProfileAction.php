<?php

namespace App\Actions\Profile;

use App\DTOs\Profile\UpdateDoctorProfileDTO;
use App\Models\User;

class UpdateDoctorProfileAction {

    public function execute(User $user, UpdateDoctorProfileDTO $dto): User {
        $userFields = array_filter([
            'first_name' => $dto->firstName,
            'last_name' => $dto->lastName,
            'phone' => $dto->phone,
        ], fn($v) => $v !== null);

        if (!empty($userFields)) $user->update($userFields);

        if ($dto->avatar) {
            $path = $dto->avatar->store('avatars', 's3');
            $user->update(['image' => $path]);
        }

        $profileFields = array_filter([
            'speciality' => $dto->speciality,
            'license_number' => $dto->licenseNumber,
            'years_experience' => $dto->yearsExperience,
            'consultation_fee'=> $dto->consultationFee,
            'bio' => $dto->bio,
        ], fn($v) => $v !== null);

        if (!empty($profileFields)) $user->doctorProfile()->update($profileFields);

        return $user->fresh()->load('doctorProfile');
    }
}