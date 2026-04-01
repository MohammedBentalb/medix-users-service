<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'description'])]
class Role extends Model {
    use HasUuids;
    
    public function permissions(): BelongsToMany{
        return $this->belongsToMany(Permission::class, 'role_permissions')->withTimestamps();
    }
}
