<?php

namespace App\Actions\Admin;

use App\Exceptions\UserNotFoundException;
use App\Models\Role;
use App\Models\User;

class AssignRolesAction {

    public function execute(string $id, array $roleNames): User {
        $user = User::find($id);
        if (!$user) throw new UserNotFoundException();

        $roleIds = Role::whereIn('name', $roleNames)->pluck('id');
        $user->roles()->sync($roleIds);

        return $user->fresh()->load('roles');
    }
}