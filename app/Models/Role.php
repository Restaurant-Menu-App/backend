<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }

    //helper functions

    public function hasPermission($permis)
    {
        $bool = false;
        foreach ($this->permissions as $permission) {
            if ($permission->slug == $permis) {
                $bool = true;
            }
        }

        return $bool;
    }

    public function hasPermissions($permissions)
    {
        foreach ($permissions as $perm) {
            if ($this->hasPermission($perm)) {
                return true;
            }
        }
    }


    public function scopeNotMyself($query)
    {
        $query->where('id', '!=', auth()->user()->role_id);
    }

    public function scopeNotDeveloper($query)
    {
        $query->where('slug', '!=', 'developer');
    }

    public function scopeNotAdmin($query)
    {
        $query->where('slug', '!=', 'admin');
    }

    public function scopeFilterOn($query)
    {
        if (request('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }
    }
}
