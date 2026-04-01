<?php

namespace App\Actions\Auth\Contracts;

use App\DTOs\Auth\LoginDTO;

interface LoginUserContract{
    public function execute(LoginDTO $credentials, string $type): array;
}