<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientProfileResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'dateOfBirth'           => $this->date_of_birth?->toDateString(),
            'gender'                => $this->gender,
            'bloodType'             => $this->blood_type,
            'address'               => $this->address,
            'emergencyContactName'  => $this->emergency_contact_name,
            'emergencyContactPhone' => $this->emergency_contact_phone,
        ];
    }
}
