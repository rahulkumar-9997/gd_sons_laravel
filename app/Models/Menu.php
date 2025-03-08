<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Menu extends Model
{
    protected $fillable = ['name', 'url', 'icon', 'parent_id'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'menu_role');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'menu_permission');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
