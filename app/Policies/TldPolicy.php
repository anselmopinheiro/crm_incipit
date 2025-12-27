<?php

namespace App\Policies;

use App\Models\Tld;
use App\Models\User;
use App\Policies\Concerns\RespectsRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class TldPolicy
{
    use HandlesAuthorization;
    use RespectsRoles;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Tld $tld): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isManager();
    }

    public function update(User $user, Tld $tld): bool
    {
        return $user->isManager();
    }

    public function delete(User $user, Tld $tld): bool
    {
        return $user->isManager();
    }
}
