<?php

namespace App\Actions\Auth\Contracts;

use App\DTOs\Auth\RegisterAssistantDTO;

interface RegisterAssistantContract {
    public function execute(RegisterAssistantDTO $userInfo): array;
}
