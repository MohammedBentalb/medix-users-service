<?php

namespace App\Actions\Auth\Contracts;

use App\DTOs\Auth\RegisterPatientDTO;

interface RegisterPatientContract {
    public function execute(RegisterPatientDTO $user): array;
}
