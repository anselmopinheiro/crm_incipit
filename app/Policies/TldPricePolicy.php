<?php

namespace App\Policies;

use App\Models\TldPrice;
use App\Models\User;
use App\Policies\Concerns\RespectsRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class TldPricePolicy
{
    use HandlesAuthorization;
    use RespectsRoles;

    public function viewAny(User $user): bool
    {
        return $user->isManager();
    }

    public function view(User $user, TldPrice $price): bool
    {
        return $user->isManager();
    }

    public function create(User $user): bool
    {
        return $user->isManager();
    }
}
