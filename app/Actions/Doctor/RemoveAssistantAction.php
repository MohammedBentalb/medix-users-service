<?php

namespace App\Actions\Doctor;

use App\Exceptions\UserNotFoundException;
use App\Models\AssistantProfile;

class RemoveAssistantAction {
    public function execute(string $doctorId, string $assistantId): void {
        $profile = AssistantProfile::where('user_id', $assistantId)->where('doctor_id', $doctorId)->first();
        if (!$profile) throw new UserNotFoundException('Assistant not found under this doctor');
        $profile->update(['doctor_id' => null]);
    }
}
