<?php

namespace App\Policies;

use App\Models\Field;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FieldPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Field $field): bool
    {
        return $user->isSuperAdmin() || $field->venue->admin_id === $user->id;
    }

    public function update(User $user, Field $field): bool
    {
        return $user->isSuperAdmin() || $field->venue->admin_id === $user->id;
    }

    public function delete(User $user, Field $field): bool
    {
        return $user->isSuperAdmin() || $field->venue->admin_id === $user->id;
    }
}
