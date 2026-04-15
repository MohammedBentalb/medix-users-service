<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'date_of_birth', 'gender', 'blood_type', 'address', 'emergency_contact_name', 'emergency_contact_phone'])]
class PatientProfile extends Model{
    use HasUuids, HasFactory;

    protected function casts(): array {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
