<?php

namespace App\Traits;

trait HasRolesAndPermissions
{
    public function checkRole($roleName): bool
    {
        $roles = ['worker' => 0, 'manager' => 1, 'administrator' => 2];
        if ($this->role == $roles[$roleName]) {
            return true;
        }
        return false;
    }
}
