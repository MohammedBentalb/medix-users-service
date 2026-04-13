<?php

namespace App\Actions\Admin;

use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Http\Request;

class ListUsersAction {
    public function execute(Request $request, bool $adminsOnly = false) {
        $query = User::query();
        if($adminsOnly) {
            $query->where('type', UserTypeEnum::ADMIN);
            if($search = $request->query('search')) $query->where('first_name', 'ilike', "%{$search}%")->orWhere('last_name', 'ilike', "%{$search}%");
            return $query->paginate($request->query('perPage', 6));
        }
        
        $query->where('type', '!=', UserTypeEnum::ADMIN);

        if ($type = $request->query('type')) $query->where('type', UserTypeEnum::from($type));

        if ($role = $request->input('role')) {
            $query->whereHas('roles', function($q) use($role) {
                $q->where('name', $role);
            });
        }      
        
        $profileRelation = match($role){
            UserTypeEnum::DOCTOR->value => 'doctorProfile',
            UserTypeEnum::PATIENT->value => 'patientProfile',
            UserTypeEnum::ASSISTANT->value => 'assistantProfile',
            default => null
        };
      
        if($profileRelation) $query->with($profileRelation);

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'ilike', "%{$search}%")
                  ->orWhere('last_name', 'ilike', "%{$search}%");
            });
        }

        return $query->paginate($request->query('perPage', 6));
    }
}