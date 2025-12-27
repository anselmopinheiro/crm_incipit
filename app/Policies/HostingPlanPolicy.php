<?php

namespace App\Policies;

use App\Models\HostingPlan;
use App\Models\User;
use App\Policies\Concerns\RespectsRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class HostingPlanPolicy
{
    use HandlesAuthorization;
    use RespectsRoles;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, HostingPlan $plan): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isManager();
    }

    public function update(User $user, HostingPlan $plan): bool
    {
        return $user->isManager();
    }

    public function delete(User $user, HostingPlan $plan): bool
    {
        return $user->isManager();
    }
}
