<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'token_hash', 'expires_at', 'revoked_at', 'ip_address', 'user_agent'])]
class RefreshToken extends Model {
    use HasUuids;

    public $timestamps = false;

    protected function casts(): array {
        return [
            'expires_at' => 'datetime',
            'revoked_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool {
        return $this->expires_at->isPast();
    }

    public function isRevoked(): bool {
        return $this->revoked_at !== null;
    }

    public function isValid(): bool {
        return !$this->isExpired() && !$this->isRevoked();
    }
}
