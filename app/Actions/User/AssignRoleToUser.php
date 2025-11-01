<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

/**
 * Assign Role to User Action
 *
 * Assigns a role to a user using Spatie Permission.
 * Follows Action-Based Architecture pattern.
 */
class AssignRoleToUser
{
    /**
     * Execute the assign role action with role name.
     *
     * Assigns a role to a user using the role name string.
     * Uses Spatie Permission package for role assignment and
     * logs the operation for audit tracking.
     *
     * @param  \App\Models\User  $user  The user to assign the role to
     * @param  string  $roleName  The name of the role to assign
     * @return \App\Models\User The updated user instance (refreshed from database)
     */
    public function execute(User $user, string $roleName): User
    {
        Log::info('Assigning role to user', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $roleName,
            'assigned_by' => Auth::id(),
        ]);

        $user->assignRole($roleName);

        Log::info('Role assigned successfully', [
            'user_id' => $user->id,
            'role' => $roleName,
        ]);

        return $user->fresh() ?? $user;
    }

    /**
     * Execute the assign role action with Role model.
     *
     * Assigns a role to a user using a Role model instance.
     * Uses Spatie Permission package for role assignment and
     * logs the operation for audit tracking.
     *
     * @param  \App\Models\User  $user  The user to assign the role to
     * @param  \Spatie\Permission\Models\Role  $role  The role model instance to assign
     * @return \App\Models\User The updated user instance (refreshed from database)
     */
    public function executeWithRole(User $user, Role $role): User
    {
        Log::info('Assigning role to user', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $role->name,
            'assigned_by' => Auth::id(),
        ]);

        $user->assignRole($role);

        Log::info('Role assigned successfully', [
            'user_id' => $user->id,
            'role' => $role->name,
        ]);

        return $user->fresh() ?? $user;
    }
}
