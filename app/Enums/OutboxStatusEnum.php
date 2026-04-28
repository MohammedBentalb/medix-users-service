<?php

namespace App\Enums;

enum OutboxStatusEnum : string  {
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case FAILED = 'failed';
}
