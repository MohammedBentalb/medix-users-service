<?php

namespace App\Actions\Profile;

use App\DTOs\Profile\UpdatePatientProfileDTO;
use App\Models\User;

class UpdatePatientProfileAction {

    public function execute(User $user, UpdatePatientProfileDTO $dto): User {
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
            'date_of_birth' => $dto->dateOfBirth,
            'gender' => $dto->gender,
            'blood_type' => $dto->bloodType,
            'address' => $dto->address,
            'emergency_contact_name' => $dto->emergencyContactName,
            'emergency_contact_phone' => $dto->emergencyContactPhone,
        ], fn($v) => $v !== null);

        if (!empty($profileFields)) $user->patientProfile()->update($profileFields);
        return $user->fresh()->load('patientProfile');
    }
}