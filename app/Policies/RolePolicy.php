<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
      // قبل أي تحقق من القدرة
    public function before($user)
    {
        if ($user->super_admin) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasAbility('role.view');
    }


    public function view( $user, Role $role): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        //return false;
        return $user->hasAbility('role.create');
    }

   
    public function update(User $user, Role $role): bool
    {
        
        return $user->hasAbility('role.update');
    }

 
    public function delete(User $user, Role $role): bool
    {
        //  return false;
        return $user->hasAbility('role.delete');
    }

    public function restore(User $user, Role $role): bool
    {
        return false;
    }


    public function forceDelete(User $user, Role $role): bool
    {
        // return false;
        return $user->hasAbility('role.delete');
    }
}
