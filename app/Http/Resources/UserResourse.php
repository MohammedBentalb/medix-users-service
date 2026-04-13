<?php

namespace App\Http\Resources;

use App\Enums\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResourse extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id'        => $this->id,
            'email'     => $this->email,
            'firstName' => $this->first_name,
            'lastName'  => $this->last_name,
            'phone'     => $this->phone,
            'image'     => $this->image ,
            'nationalId'=> $this->national_id,
            'type'      => $this->type,
            'status'    => $this->status,
            'profile'   => $this->resolveProfile(),
            'createdAt' => $this->created_at?->toIso8601String(),
            'roles' => $this->whenLoaded('roles', fn($roles) => $roles->pluck('name')->values()),
        ];
    }

    private function resolveProfile(): mixed {
        return match($this->type->value) {
            UserTypeEnum::PATIENT->value => $this->whenLoaded('patientProfile',
                fn() => new PatientProfileResource($this->patientProfile)
            ),
            UserTypeEnum::DOCTOR->value => $this->whenLoaded('doctorProfile',
                fn() => new DoctorProfileResource($this->doctorProfile)
            ),
            UserTypeEnum::ASSISTANT->value => $this->whenLoaded('assistantProfile',
                fn() => new AssistantProfileResource($this->assistantProfile)
            ),
            default => null,
        };
    }
}
