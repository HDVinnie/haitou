<?php

namespace App\Traits;

use App\Models\Allow;
use App\Models\Group;

trait HasPermissions
{
    public function givePermissionsTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        //dd($permissions);
        if ($permissions === null) {
            return $this;
        }
        $this->allows()->saveMany($permissions);
        return $this;
    }

    public function withdrawPermissionsTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        return $this->allows()->detach($permissions);
    }

    public function refreshPermissions(...$permissions)
    {
        $this->allows()->detach();
        return$this->givePermissionsTo($permissions);
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermission($permission);
    }

    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->group as $group) {
            if ($this->group()->contains($group)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole(...$groups)
    {
        foreach ($groups as $group) {
            if ($this->group()->contains('slug', $group)) {
                return true;
            }
        }
        return false;
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function allows()
    {
        return $this->belongsToMany(Allow::class, 'user_allows');
    }

    protected function hasPermission($permission)
    {
        return (bool)$this->allows()->where('slug', $permission->slug)->count();
    }

    protected function getAllPermissions(array $permissions)
    {
        return $this->allows()->whereIn('slug', $permissions)->get();
    }
}