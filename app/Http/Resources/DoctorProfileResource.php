<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorProfileResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'speciality'      => $this->speciality,
            'licenseNumber'   => $this->license_number,
            'yearsExperience' => $this->years_experience,
            'consultationFee' => $this->consultation_fee,
            'bio'             => $this->bio,
        ];
    }
}
