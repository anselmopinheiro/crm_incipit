<?php

namespace App\Policies;

use App\Models\HostingService;
use App\Models\User;
use App\Policies\Concerns\AccountScoped;
use App\Policies\Concerns\RespectsRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class HostingServicePolicy
{
    use HandlesAuthorization;
    use RespectsRoles;
    use AccountScoped;

    public function viewAny(User $user): bool
    {
        return $user->isManager();
    }

    public function view(User $user, HostingService $service): bool
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

    public function update(User $user, HostingService $service): bool
    {
        return $user->isManager();
    }

    public function delete(User $user, HostingService $service): bool
    {
        return $user->isManager();
    }
}
