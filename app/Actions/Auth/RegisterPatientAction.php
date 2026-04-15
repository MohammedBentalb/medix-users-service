<?php

namespace App\Actions\Auth;

use App\Actions\Auth\Contracts\RegisterPatientContract;
use App\DTOs\Auth\RegisterPatientDTO;
use App\Models\PatientProfile;
use App\Models\User;
use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use App\Services\RefreshTokenSerice;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class RegisterPatientAction implements RegisterPatientContract {

    public function __construct(private RefreshTokenSerice $refreshTokenService) {}

    public function execute(RegisterPatientDTO $userInfo): array {
        $user = DB::transaction(function () use ($userInfo) {
            $user = User::create([
                'first_name' => $userInfo->firstName,
                'last_name' => $userInfo->lastName,
                'email' => $userInfo->email,
                'password' => $userInfo->password,
                'phone' => $userInfo->phone,
                'national_id' => $userInfo->nationalId,
                'type' => UserTypeEnum::PATIENT,
                'status' => UserStatusEnum::ACTIVE,
            ]);

            PatientProfile::create([
                'user_id' => $user->id,
                'date_of_birth' => $userInfo->dateOfBirth,
                'gender' => $userInfo->gender,
                'blood_type' => $userInfo->bloodType,
                'address' => $userInfo->address,
                'emergency_contact_name' => $userInfo->emergencyContactName,
                'emergency_contact_phone' => $userInfo->emergencyContactPhone,
            ]);

            $user->roles()->attach([
                Role::where('name', UserTypeEnum::USER->value)->first()->id,
                Role::where('name', UserTypeEnum::PATIENT->value)->first()->id,
            ]);

            return $user;
        });

        if ($userInfo->avatar) {
            $path = $userInfo->avatar->store('image', 's3');
            $user->update(['image' => $path]);
        }

        $token = JWTAuth::fromUser($user);
        $refreshToken = $this->refreshTokenService->issue($user);
        return ['user' => $user->load('patientProfile'), 'accessToken' => $token, 'refreshToken' => $refreshToken];
    }
}
