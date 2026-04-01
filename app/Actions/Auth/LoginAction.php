<?php


namespace App\Actions\Auth;

use App\Actions\Auth\Contracts\LoginUserContract;
use App\DTOs\Auth\LoginDTO;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\WrongLoginPortalException;
use App\Services\RefreshTokenSerice;
use App\Enums\UserTypeEnum;

class LoginAction implements LoginUserContract {

    public function __construct(private RefreshTokenSerice $refreshTokenService) {}

    public function execute(LoginDTO $credentials, string $type): array {
        if(!$token = auth('api')->attempt(['email' => $credentials->email, 'password' => $credentials->password])) throw new InvalidCredentialsException();
        $user = auth('api')->user();
        
        if($user->type !== UserTypeEnum::from($type)){
            auth('api')->logout();
            throw new WrongLoginPortalException();
        };

        $refreshToken = $this->refreshTokenService->issue($user);
        return ['user' => $user, 'accessToken' => $token, 'refreshToken' => $refreshToken];
    }
}