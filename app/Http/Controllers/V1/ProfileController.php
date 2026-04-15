<?php

namespace App\Http\Controllers\V1;

use App\Actions\Profile\ChangePasswordAction;
use App\Actions\Profile\GetProfileAction;
use App\Actions\Profile\UpdateAssistantProfileAction;
use App\Actions\Profile\UpdateDoctorProfileAction;
use App\Actions\Profile\UpdatePatientProfileAction;
use App\DTOs\Profile\ChangePasswordDTO;
use App\DTOs\Profile\UpdateAssistantProfileDTO;
use App\DTOs\Profile\UpdateDoctorProfileDTO;
use App\DTOs\Profile\UpdatePatientProfileDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Http\Requests\Profile\UpdateAssistantProfileRequest;
use App\Http\Requests\Profile\UpdateDoctorProfileRequest;
use App\Http\Requests\Profile\UpdatePatientProfileRequest;
use App\Http\Resources\UserResourse;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller {

    public function __construct(
        private GetProfileAction $getProfileAction,
        private UpdatePatientProfileAction $updatePatientAction,
        private UpdateDoctorProfileAction $updateDoctorAction,
        private UpdateAssistantProfileAction $updateAssistantAction,
        private ChangePasswordAction $changePasswordAction,
    ) {}

    public function show(): JsonResponse {
        $user = User::findOrFail(request()->header('X-User-Id'));
        $user = $this->getProfileAction->execute($user);
        return ApiResponse::success(['user' => new UserResourse($user->load('roles'))]);
    }

    public function updatePatient(UpdatePatientProfileRequest $request): JsonResponse {
        $user = User::findOrFail(request()->header('X-User-Id'));
        $user = $this->updatePatientAction->execute($user, UpdatePatientProfileDTO::fromRequest($request));
        return ApiResponse::success(['user' => new UserResourse($user)]);
    }

    public function updateDoctor(UpdateDoctorProfileRequest $request): JsonResponse {
        $user = User::findOrFail(request()->header('X-User-Id'));
        $user = $this->updateDoctorAction->execute($user, UpdateDoctorProfileDTO::fromRequest($request));
        return ApiResponse::success(['user' => new UserResourse($user)]);
    }

    public function updateAssistant(UpdateAssistantProfileRequest $request): JsonResponse {
        $user = User::findOrFail(request()->header('X-User-Id'));
        $user = $this->updateAssistantAction->execute($user, UpdateAssistantProfileDTO::fromRequest($request));
        return ApiResponse::success(['user' => new UserResourse($user)]);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse {
        $user = User::findOrFail(request()->header('X-User-Id'));
        $this->changePasswordAction->execute($user, ChangePasswordDTO::fromRequest($request));
        return ApiResponse::success(['message' => 'Password updated successfully.']);
    }
}
