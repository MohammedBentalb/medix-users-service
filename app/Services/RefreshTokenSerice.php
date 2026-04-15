<?php

namespace App\Services;

use App\Exceptions\InvalidRefreshToken;
use App\Models\RefreshToken;
use App\Models\User;
use Error;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Exceptions\UserNotDefinedException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class RefreshTokenSerice {
    public function issue(User $user){
        $raw = Str::random(64);
        RefreshToken::create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $raw),
            'expires_at' => now()->addDays(7),
        ]);
        return $raw;
    }

    public function validate(string $rawToken): array {
        $refreshToken = RefreshToken::where('token_hash', hash('sha256', $rawToken))->first();
        if(!$refreshToken || !$refreshToken->isValid()) throw new InvalidRefreshToken();
        $user = User::find($refreshToken->user_id);
        if(!$user) throw new UserNotDefinedException();

        return ['refreshToken' => $rawToken, 'accessToken' => JWTAuth::fromUser($user)];
    }

    public function revoke(string $rawToken) {
        RefreshToken::where('token_hash', hash('sha256', $rawToken))->update(['revoked_at' => now()]);
    }

}
