<?php

namespace App\Actions\Admin;

use App\Exceptions\UserNotFoundException;
use App\Models\User;

class GetUserAction {

    public function execute(string $id): User {
        $user = User::find($id);
        if (!$user) throw new UserNotFoundException();
        return $user->loadProfile();
    }
}