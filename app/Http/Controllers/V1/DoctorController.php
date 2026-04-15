<?php

namespace App\Http\Controllers\V1;

use App\Actions\Doctor\AssignAssistantAction;
use App\Actions\Doctor\ListDoctorAssistantsAction;
use App\Actions\Doctor\ListDoctorPatientsAction;
use App\Actions\Doctor\ListPatientDoctorsAction;
use App\Actions\Doctor\RemoveAssistantAction;
use App\Enums\UserTypeEnum;
use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\AssignAssistantRequest;
use App\Http\Resources\UserResourse;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorController extends Controller {
    public function __construct(private AssignAssistantAction $assignAssistantAction, private ListDoctorAssistantsAction $listAssistantsAction, private RemoveAssistantAction $removeAssistantAction,  private ListDoctorPatientsAction $listDoctorPatientsAction, private ListPatientDoctorsAction $listPatientDoctorsAction,) {}

    public function assignAssistant(AssignAssistantRequest $request): JsonResponse {
        $doctorId = $request->header('X-User-Id');
        $user = $this->assignAssistantAction->execute($doctorId, $request->validated('assistantId'));
        return ApiResponse::success(new UserResourse($user));
    }

    public function listAssistants(Request $request): JsonResponse {
        $doctorId = $request->header('X-User-Id');
        $paginator = $this->listAssistantsAction->execute($doctorId, $request);
        return ApiResponse::UsersWithPaginationResponse($paginator);
    }

    public function removeAssistant(Request $request, string $assistantId): JsonResponse {
        $doctorId = $request->header('X-User-Id');
        $this->removeAssistantAction->execute($doctorId, $assistantId);
        return ApiResponse::success(['message' => 'Assistant removed successfully'], 200);
    }

    public function listDoctorPatients(Request $request): JsonResponse {
        $doctorId = $request->header('X-User-Id');
        
        $roles = explode(',', $request->header('X-User-Roles', ''));
        if (in_array(UserTypeEnum::ASSISTANT->value, $roles)) {
            $assistant = User::find($request->header('X-User-Id'));
            if(!$assistant) throw new UserNotFoundException();
            $doctorId = $assistant->assistantProfile->doctor_id;
        } 
        $paginator = $this->listDoctorPatientsAction->execute($doctorId, $request);
        return ApiResponse::UsersWithPaginationResponse($paginator);
    } 

    public function listPatientDoctors(Request $request): JsonResponse {
        $patientId = $request->header('X-User-Id');
        $paginator = $this->listPatientDoctorsAction->execute($patientId, $request);
        return ApiResponse::UsersWithPaginationResponse($paginator);
    }
}
