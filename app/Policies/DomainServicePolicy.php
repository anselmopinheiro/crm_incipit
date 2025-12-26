<?php

namespace App\Policies;

use App\Models\DomainService;
use App\Models\User;
use App\Policies\Concerns\AccountScoped;
use App\Policies\Concerns\RespectsRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class DomainServicePolicy
{
    use HandlesAuthorization;
    use RespectsRoles;
    use AccountScoped;

    public function viewAny(User $user): bool
    {
        return $user->isManager() || $user->isReseller() || $user->isClient();
    }

    public function view(User $user, DomainService $service): bool
    {
        if ($user->isManager()) {
            return true;
        }

        return $this->canAccessAccount($user, $service->account);
    }

    public function create(User $user): bool
    {
        return $user->isManager();
    }

    public function update(User $user, DomainService $service): bool
    {
        return $user->isManager();
    }

    public function delete(User $user, DomainService $service): bool
    {
        return $user->isManager();
    }
}
