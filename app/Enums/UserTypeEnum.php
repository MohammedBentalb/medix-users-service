<?php

namespace App\Enums;

enum UserTypeEnum: string {
    case PATIENT = 'ROLE_PATIENT';
    case DOCTOR = 'ROLE_DOCTOR';
    case ASSISTANT = 'ROLE_ASSISTANT';
    case ADMIN = 'ROLE_ADMIN';
    case USER = 'ROLE_USER';
}
