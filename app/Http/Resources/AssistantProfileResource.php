<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssistantProfileResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'doctorId' => $this->doctor_id,
        ];
    }
}
