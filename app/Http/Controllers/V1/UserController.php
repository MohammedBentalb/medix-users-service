<?php

namespace App\Http\Controllers\V1;

use App\Actions\Admin\AssignRolesAction;
use App\Actions\Admin\GetUserAction;
use App\Actions\Admin\ListUsersAction;
use App\Actions\Admin\UpdateUserStatusAction;
use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AssignRolesRequest;
use App\Http\Requests\Admin\UpdateUserStatusRequest;
use App\Http\Resources\UserResourse;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller {

    public function __construct(
        private ListUsersAction $listUsersAction,
        private GetUserAction $getUserAction,
        private UpdateUserStatusAction $updateUserStatusAction,
        private AssignRolesAction $assignRolesAction,
    ) {}

    public function index(Request $request): JsonResponse {
        $paginator = $this->listUsersAction->execute($request);
        return ApiResponse::UsersWithPaginationResponse($paginator);
    }

    public function getAdmins(Request $request): JsonResponse {
        $paginator = $this->listUsersAction->execute($request, true);
        return ApiResponse::UsersWithPaginationResponse($paginator);
    }

    public function getDoctors(Request $request): JsonResponse {
        $request->merge(['role' => UserTypeEnum::DOCTOR->value]);
        $paginator = $this->listUsersAction->execute($request);
        return ApiResponse::UsersWithPaginationResponse($paginator);
    }

    public function getAssistants(Request $request): JsonResponse {
        $request->merge(['role' => UserTypeEnum::ASSISTANT->value]);
        $paginator = $this->listUsersAction->execute($request);
        return ApiResponse::UsersWithPaginationResponse($paginator);
    }

    public function getPatients(Request $request): JsonResponse {
        $request->merge(['role' => UserTypeEnum::PATIENT->value]);
        $paginator = $this->listUsersAction->execute($request);
        return ApiResponse::UsersWithPaginationResponse($paginator);
    }


    public function show(string $id): JsonResponse {
        $user = $this->getUserAction->execute($id);
        return ApiResponse::success(new UserResourse($user));
    }

    public function updateStatus(UpdateUserStatusRequest $request, string $id): JsonResponse {
        $user = $this->updateUserStatusAction->execute($id, UserStatusEnum::from($request->validated('status')));
        return ApiResponse::success(new UserResourse($user));
    }

    public function assignRoles(AssignRolesRequest $request, string $id): JsonResponse {
        $user = $this->assignRolesAction->execute($id, $request->validated('roles'));
        return ApiResponse::success(new UserResourse($user));
    }
}
