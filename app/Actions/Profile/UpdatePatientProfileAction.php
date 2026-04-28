<?php

namespace App\Actions\Profile;

use App\DTOs\Profile\UpdatePatientProfileDTO;
use App\Models\OutboxEvent;
use App\Models\User;

class UpdatePatientProfileAction {

    public function execute(User $user, UpdatePatientProfileDTO $dto): User {
        $userFields = array_filter([
            'first_name' => $dto->firstName,
            'last_name' => $dto->lastName,
            'phone' => $dto->phone,
        ], fn($v) => $v !== null);

        if (!empty($userFields)) $user->update($userFields);

        if(isset($userFields['first_name']) || isset($userFields['last_name'])){
            OutboxEvent::create([
                'topic' => 'user.name_updated',
                'payload'=> [
                    'user_id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'role' => $user->type->value,
                ]
            ]);
        }

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