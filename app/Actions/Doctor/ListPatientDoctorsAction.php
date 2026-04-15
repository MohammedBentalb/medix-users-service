<?php

namespace App\Actions\Doctor;

use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ListPatientDoctorsAction {
    public function execute(string $patientId, Request $request): LengthAwarePaginator {
        $patient = User::find($patientId);
        if (!$patient) throw new UserNotFoundException();

        return $patient->doctors()->with('doctorProfile')->when($request->query('search'), function($q, $search) {
            $q->where(function($nq) use ($search) {
                $nq->where('first_name', 'ilike', "%$search%")->orWhere('last_name', 'ilike', "%$search%");
            });
        })->paginate($request->query('perPage', 15));
    }
}
