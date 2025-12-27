<?php

namespace App\Policies\Concerns;

use App\Models\User;

trait RespectsRoles
{
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    protected function canManage(User $user): bool
    {
        return $user->isManager();
    }

    protected function canReadOwn(User $user): bool
    {
        return $user->isReseller() || $user->isClient();
    }
}
