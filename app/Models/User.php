<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

#[Fillable(['email', 'password', 'first_name', 'last_name', 'phone', 'image', 'national_id', 'status', 'type'])]
#[Hidden(['password'])]
class User extends Authenticatable implements JWTSubject{
    
    use HasUuids, HasFactory, Notifiable, SoftDeletes;

    protected function casts(): array {
        return [
        'password' => 'hashed',
            'status' => UserStatusEnum::class,
            'type' => UserTypeEnum::class,
        ];
    }

    public function patients(): BelongsToMany{
        return $this->belongsToMany(self::class, 'doctors_patients', 'doctor_id', 'patient_id')->withTimestamps();
    }
    
    public function doctors(): BelongsToMany{
        return $this->belongsToMany(self::class, 'doctors_patients', 'patient_id', 'doctor_id')->withTimestamps();
    }


    public function roles(): BelongsToMany {
        return $this->belongsToMany(Role::class, 'user_roles')->withTimestamps();
    }

    public function patientProfile(): HasOne {
        return $this->hasOne(PatientProfile::class);
    }

    public function doctorProfile(): HasOne {
        return $this->hasOne(DoctorProfile::class);
    }

    public function assistantProfile(): HasOne {
        return $this->hasOne(AssistantProfile::class);
    }

    public function assistants(): HasMany {
        return $this->hasMany(AssistantProfile::class, 'doctor_id');
    }

    public function refreshTokens(): HasMany {
        return $this->hasMany(RefreshToken::class);
    }

    public function getJWTCustomClaims(){
        $roles = $this->roles()->with('permissions')->get();

        return [
            'sub' => $this->id,
            'type' => $this->type->value,
            'roles' => $roles->pluck('name')->toArray(),
            'permissions' => $roles->flatMap(fn($role) => $role->permissions->pluck('name'))->unique()->values()->toArray(),
        ];
    }
    
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function loadProfile(){
        $relation = match($this->type->value) {
            UserTypeEnum::PATIENT->value => 'patientProfile',
            UserTypeEnum::DOCTOR->value => 'doctorProfile',
            UserTypeEnum::ASSISTANT->value => 'assistantProfile',
            default => null,
        };

        if ($relation) $this->load($relation);
        return $this;    
    }
}
