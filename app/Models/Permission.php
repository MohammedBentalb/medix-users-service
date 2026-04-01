<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable(['name', 'description'])]
class Permission extends Model {
    use HasUuids, HasFactory;

    public function roles(): BelongsToMany{
        return $this->belongsToMany(Role::class, 'role_permissions')->withTimestamps();
    }
}
