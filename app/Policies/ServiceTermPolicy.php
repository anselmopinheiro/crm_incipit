<?php

namespace App\Policies;

use App\Models\ServiceTerm;
use App\Models\User;
use App\Policies\Concerns\AccountScoped;
use App\Policies\Concerns\RespectsRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceTermPolicy
{
    use HandlesAuthorization;
    use RespectsRoles;
    use AccountScoped;

    public function view(User $user, ServiceTerm $term): bool
    {
        if ($user->isManager()) {
            return true;
        }

        $service = $term->service;
        if (! $service || ! $service->account) {
            return false;
        }

        return $this->canAccessAccount($user, $service->account);
    }

    public function create(User $user): bool
    {
        return $user->isManager();
    }

    public function update(User $user, ServiceTerm $term): bool
    {
        return $user->isManager();
    }
}
