<?php

namespace App\Actions\Doctor;

use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ListDoctorAssistantsAction {
    public function execute(string $doctorId, Request $request): LengthAwarePaginator {
        $query = User::where('type', UserTypeEnum::ASSISTANT)->whereHas('assistantProfile', fn($q) => $q->where('doctor_id', $doctorId));

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'ilike', "%$search%")->orWhere('last_name', 'ilike', "%{$search}%")->orWhere('email', 'ilike', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) $query->where('status', UserStatusEnum::from($status));
        return $query->with('assistantProfile')->paginate($request->query('perPage', 15));
    }
}
