<?php

namespace App\Actions\Profile;

use App\DTOs\Profile\UpdateAssistantProfileDTO;
use App\Models\User;

class UpdateAssistantProfileAction {

    public function execute(User $user, UpdateAssistantProfileDTO $dto): User {
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
        return $user->fresh()->load('assistantProfile');
    }
}