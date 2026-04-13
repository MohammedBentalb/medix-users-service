<?php

namespace App\Actions\Doctor;

use App\Enums\UserTypeEnum;
use App\Exceptions\UserNotFoundException;
use App\Models\User;

class AssignAssistantAction {
    public function execute(string $doctorId, string $assistantId){
        $doctor = User::where('id', $doctorId)->where('type', UserTypeEnum::DOCTOR)->first();
        if (!$doctor) throw new UserNotFoundException('Doctor not found');

        $assistant = User::where('id', $assistantId)->where("type", UserTypeEnum::ASSISTANT)->first();
        if (!$assistant) throw new UserNotFoundException('Assistant not found');

        $assistant->assistantProfile()->update(['doctor_id' => $doctorId]);
        return $assistant->fresh()->load("assistantProfile");
    }
}
