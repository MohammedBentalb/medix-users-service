<?php

namespace App\Actions\Profile;

use App\DTOs\Profile\UpdateDoctorProfileDTO;
use App\Models\OutboxEvent;
use App\Models\User;

class UpdateDoctorProfileAction {

    public function execute(User $user, UpdateDoctorProfileDTO $dto): User {
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