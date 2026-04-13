<?php

namespace App\Actions\Doctor;

use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Http\Request;

class ListDoctorPatientsAction {
    public function execute(string $doctorId, Request $request) {
        $doctor = User::find($doctorId);
        if(!$doctor) throw new UserNotFoundException();

        return $doctor->patients()->with('patientProfile')->when($request->query('search'), function($q, $search){
            $q->where(function($nq) use ($search){
                $nq->where('first_name', 'ilike', "%$search%")->orWhere('last_name', 'ilike', "%$search%");
            });
        })->paginate($request->query("perPage", 15));        
    }
}
