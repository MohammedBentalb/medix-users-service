<?php

namespace App\Actions\Profile;

use App\DTOs\Profile\ChangePasswordDTO;
use App\Exceptions\InvalidPasswordException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAction {

    public function execute(User $user, ChangePasswordDTO $dto): void {
        if (!Hash::check($dto->currentPassword, $user->password)) {
            throw new InvalidPasswordException();
        }

        $user->update(['password' => $dto->newPassword]);
    }
}