<?php

namespace App\Http\Controllers\V1;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\RegisterAssistantAction;
use App\Actions\Auth\RegisterDoctorAction;
use App\Actions\Auth\RegisterPatientAction;
use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterAssistantDTO;
use App\DTOs\Auth\RegisterDoctorDTO;
use App\DTOs\Auth\RegisterPatientDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterAssistantRequest;
use App\Http\Requests\Auth\RegisterDoctorRequest;
use App\Http\Requests\Auth\RegisterPatientRequest;
use App\Http\Resources\UserResourse;
use App\Http\Responses\ApiResponse;
use App\Services\RefreshTokenSerice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller {

    public function __construct(
        private LoginAction            $loginAction,
        private RegisterPatientAction  $registerPatientAction,
        private RegisterDoctorAction   $registerDoctorAction,
        private RegisterAssistantAction $registerAssistantAction,
        private RefreshTokenSerice     $refreshTokenService,
    ) {}

    public function login(LoginRequest $request): JsonResponse {
        $result = $this->loginAction->execute(
            LoginDTO::fromRequest($request),
            $request->validated('type'),
        );

        return ApiResponse::success([
            'accessToken'  => $result['accessToken'],
            'refreshToken'=> $result['refreshToken'],
            'tokenType' => 'Bearer',
            'expiresIn' => config('jwt.ttl') * 60,
            'user' => new UserResourse($result['user']->loadProfile()),
        ]);
    }

    public function logout(Request $request): JsonResponse {
        $this->refreshTokenService->revoke($request->input('refreshToken'));
        auth('api')->logout();
        return ApiResponse::success(['message' => 'Logged out successfully.']);
    }

    public function registerPatient(RegisterPatientRequest $request): JsonResponse {
        $result = $this->registerPatientAction->execute(RegisterPatientDTO::fromRequest($request));

        return ApiResponse::success([
            'accessToken' => $result['accessToken'],
            'refreshToken' => $result['refreshToken'],
            'tokenType' => 'Bearer',
            'expiresIn' => config('jwt.ttl') * 60,
            'user' => new UserResourse($result['user']),
        ], 201);
    }

    public function registerDoctor(RegisterDoctorRequest $request): JsonResponse {
        $result = $this->registerDoctorAction->execute(RegisterDoctorDTO::fromRequest($request));

        return ApiResponse::success([
            'accessToken'  => $result['accessToken'],
            'refreshToken' => $result['refreshToken'],
            'tokenType'    => 'Bearer',
            'expiresIn'    => config('jwt.ttl') * 60,
            'user'         => new UserResourse($result['user']),
        ], 201);
    }

    public function registerAssistant(RegisterAssistantRequest $request): JsonResponse {
        $result = $this->registerAssistantAction->execute(RegisterAssistantDTO::fromRequest($request));

        return ApiResponse::success([
            'accessToken'  => $result['accessToken'],
            'refreshToken' => $result['refreshToken'],
            'tokenType'    => 'Bearer',
            'expiresIn'    => config('jwt.ttl') * 60,
            'user'         => new UserResourse($result['user']),
        ], 201);
    }

    public function refresh(Request $request): JsonResponse {
        $request->validate(['refreshToken' => ['required', 'string']]);

        $result = $this->refreshTokenService->validate($request->refreshToken);

        return ApiResponse::success([
            'accessToken'  => $result['accessToken'],
            'refreshToken' => $result['refreshToken'],
            'tokenType'    => 'Bearer',
            'expiresIn'    => config('jwt.ttl') * 60,
        ]);
    }
}
