<?php

namespace App\Actions\Auth;

use App\Actions\Auth\Contracts\RegisterDoctorContract;
use App\DTOs\Auth\RegisterDoctorDTO;
use App\Models\DoctorProfile;
use App\Models\User;
use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use App\Exceptions\DuplicatedEmailException;
use App\Exceptions\DuplicatedLicenseNumberException;
use App\Exceptions\DuplicatedNationalIdException;
use App\Services\RefreshTokenSerice;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class RegisterDoctorAction implements RegisterDoctorContract {

    public function __construct(private RefreshTokenSerice $refreshTokenService) {}

    public function execute(RegisterDoctorDTO $userInfo): array {
        $foundUser = User::where('email', $userInfo->email)->first();
        if ($foundUser) throw new DuplicatedEmailException();

        $foundNationalId = User::where('national_id', $userInfo->nationalId)->first();
        if ($foundNationalId) throw new DuplicatedNationalIdException();

        $foundLicenseNumber = DoctorProfile::where('license_number', $userInfo->licenseNumber)->first();
        if ($foundLicenseNumber) throw new DuplicatedLicenseNumberException();

        $user = DB::transaction(function () use ($userInfo) {
            $user = User::create([
                'first_name'  => $userInfo->firstName,
                'last_name'   => $userInfo->lastName,
                'email'       => $userInfo->email,
                'password'    => $userInfo->password,
                'phone'       => $userInfo->phone,
                'national_id' => $userInfo->nationalId,
                'type'        => UserTypeEnum::DOCTOR,
                'status'      => UserStatusEnum::PENDING,
            ]);

            DoctorProfile::create([
                'user_id'          => $user->id,
                'speciality'       => $userInfo->speciality,
                'license_number'   => $userInfo->licenseNumber,
                'years_experience' => $userInfo->yearsExperience,
                'consultation_fee' => $userInfo->consultationFee,
                'bio'              => $userInfo->bio,
            ]);

            $user->roles()->attach([
                Role::where('name', UserTypeEnum::USER->value)->first()->id,
                Role::where('name', UserTypeEnum::DOCTOR->value)->first()->id,
            ]);

            return $user;
        });

        if ($userInfo->avatar) {
            $path = $userInfo->avatar->store('avatars', 's3');
            $user->update(['image' => $path]);
        }

        $token        = JWTAuth::fromUser($user);
        $refreshToken = $this->refreshTokenService->issue($user);

        return ['user' => $user->load('doctorProfile'), 'accessToken' => $token, 'refreshToken' => $refreshToken];
    }
}
