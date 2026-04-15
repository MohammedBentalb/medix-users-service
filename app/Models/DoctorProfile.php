<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'speciality', 'license_number', 'years_experience', 'consultation_fee', 'bio'])]
class DoctorProfile extends Model {
    use HasUuids, HasFactory;

    protected function casts(): array {
        return [
            'years_experience' => 'integer',
            'consultation_fee' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
