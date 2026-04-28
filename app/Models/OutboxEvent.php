<?php

namespace App\Models;

use App\Enums\OutboxStatusEnum;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['topic', 'payload', 'status', 'attempts'])]
class OutboxEvent extends Model {
    use HasUuids;

    protected function casts() {
        return [
            'status' => OutboxStatusEnum::class,
            'payload' => 'array',
            'attempts' => 'integer'
        ];
    }
}
