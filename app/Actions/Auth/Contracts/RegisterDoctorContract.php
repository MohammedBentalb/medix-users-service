<?php

namespace App\Actions\Auth\Contracts;

use App\DTOs\Auth\RegisterDoctorDTO;

interface RegisterDoctorContract {
    public function execute(RegisterDoctorDTO $userInfo): array;
}
