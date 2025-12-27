<?php

namespace App\Policies;

use App\Models\HostingPlanPrice;
use App\Models\User;
use App\Policies\Concerns\RespectsRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class HostingPlanPricePolicy
{
    use HandlesAuthorization;
    use RespectsRoles;

    public function viewAny(User $user): bool
    {
        return $user->isManager();
    }

    public function view(User $user, HostingPlanPrice $price): bool
    {
        return $user->isManager();
    }

    public function create(User $user): bool
    {
        return $user->isManager();
    }
}
