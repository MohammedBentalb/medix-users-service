<?php

namespace App\Actions\Auth;

use App\Actions\Auth\Contracts\RegisterAssistantContract;
use App\DTOs\Auth\RegisterAssistantDTO;
use App\Models\AssistantProfile;
use App\Models\User;
use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use App\Exceptions\DuplicatedEmailException;
use App\Exceptions\DuplicatedNationalIdException;
use App\Services\RefreshTokenSerice;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class RegisterAssistantAction implements RegisterAssistantContract {

    public function __construct(private RefreshTokenSerice $refreshTokenService) {}

    public function execute(RegisterAssistantDTO $userInfo): array {
        $foundUser = User::where('email', $userInfo->email)->first();
        if ($foundUser) throw new DuplicatedEmailException();

        $foundNationalId = User::where('national_id', $userInfo->nationalId)->first();
        if ($foundNationalId) throw new DuplicatedNationalIdException();

        $user = DB::transaction(function () use ($userInfo) {
            $user = User::create([
                'first_name'  => $userInfo->firstName,
                'last_name'   => $userInfo->lastName,
                'email'       => $userInfo->email,
                'password'    => $userInfo->password,
                'phone'       => $userInfo->phone,
                'national_id' => $userInfo->nationalId,
                'type'        => UserTypeEnum::ASSISTANT,
                'status'      => UserStatusEnum::PENDING,
            ]);

            AssistantProfile::create([
                'user_id' => $user->id,
            ]);

            $user->roles()->attach([
                Role::where('name', UserTypeEnum::USER->value)->first()->id,
                Role::where('name', UserTypeEnum::ASSISTANT->value)->first()->id,
            ]);

            return $user;
        });

        if ($userInfo->avatar) {
            $path = $userInfo->avatar->store('avatars', 's3');
            $user->update(['image' => $path]);
        }

        $token        = JWTAuth::fromUser($user);
        $refreshToken = $this->refreshTokenService->issue($user);

        return ['user' => $user->load('assistantProfile'), 'accessToken' => $token, 'refreshToken' => $refreshToken];
    }
}
