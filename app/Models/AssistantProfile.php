<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'doctor_id'])]
class AssistantProfile extends Model
{
    use HasUuids, HasFactory;

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function doctor(): BelongsTo {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
