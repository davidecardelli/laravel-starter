<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

/**
 * Remove Role from User Action
 *
 * Removes a role from a user using Spatie Permission.
 * Follows Action-Based Architecture pattern.
 */
class RemoveRoleFromUser
{
    /**
     * Execute the remove role action with role name.
     *
     * Removes a role from a user using the role name string.
     * Uses Spatie Permission package for role removal and
     * logs the operation for audit tracking.
     *
     * @param  \App\Models\User  $user  The user to remove the role from
     * @param  string  $roleName  The name of the role to remove
     * @return \App\Models\User The updated user instance (refreshed from database)
     */
    public function execute(User $user, string $roleName): User
    {
        Log::info('Removing role from user', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $roleName,
            'removed_by' => Auth::id(),
        ]);

        $user->removeRole($roleName);

        Log::info('Role removed successfully', [
            'user_id' => $user->id,
            'role' => $roleName,
        ]);

        return $user->fresh() ?? $user;
    }

    /**
     * Execute the remove role action with Role model.
     *
     * Removes a role from a user using a Role model instance.
     * Uses Spatie Permission package for role removal and
     * logs the operation for audit tracking.
     *
     * @param  \App\Models\User  $user  The user to remove the role from
     * @param  \Spatie\Permission\Models\Role  $role  The role model instance to remove
     * @return \App\Models\User The updated user instance (refreshed from database)
     */
    public function executeWithRole(User $user, Role $role): User
    {
        Log::info('Removing role from user', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $role->name,
            'removed_by' => Auth::id(),
        ]);

        $user->removeRole($role);

        Log::info('Role removed successfully', [
            'user_id' => $user->id,
            'role' => $role->name,
        ]);

        return $user->fresh() ?? $user;
    }
}
