<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    // رابطه ی نقش با دسترسی ها
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }


    /**
     * @param Permission $permission
     * @return bool
     */

    public function hasPermission($permission_name)
    {
        $permission = Permission::where('title', '=', $permission_name)->first();

        return $this->permissions()
            ->where('id', $permission->id)
            ->exists();
    }
}
