<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use App\Policies\Concerns\AccountScoped;
use App\Policies\Concerns\RespectsRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;
    use RespectsRoles;
    use AccountScoped;

    public function viewAny(User $user): bool
    {
        return $user->isManager();
    }

    public function view(User $user, Account $account): bool
    {
        if ($user->isManager()) {
            return true;
        }

        return $this->canAccessAccount($user, $account);
    }

    public function create(User $user): bool
    {
        return $user->isManager();
    }

    public function update(User $user, Account $account): bool
    {
        return $user->isManager();
    }

    public function delete(User $user, Account $account): bool
    {
        return $user->isManager();
    }
}
