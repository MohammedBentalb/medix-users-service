<?php

namespace App\Actions\Admin;

use App\Enums\UserStatusEnum;
use App\Exceptions\UserNotFoundException;
use App\Models\User;

class UpdateUserStatusAction {

    public function execute(string $id, UserStatusEnum $status): User {
        $user = User::find($id);
        if (!$user) throw new UserNotFoundException();

        $user->update(['status' => $status]);

        return $user->fresh();
    }
}