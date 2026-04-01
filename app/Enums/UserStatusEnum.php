<?php

namespace App\Enums;

enum UserStatusEnum: string {
    case ACTIVE = 'ACTIVE';
    case SUSPENDED = 'SUSPENDED';
    case PENDING = 'PENDING';
}