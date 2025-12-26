<?php

namespace App\Policies;

use App\Models\RenewalRequest;
use App\Models\User;
use App\Policies\Concerns\AccountScoped;
use App\Policies\Concerns\RespectsRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class RenewalRequestPolicy
{
    use HandlesAuthorization;
    use RespectsRoles;
    use AccountScoped;

    public function view(User $user, RenewalRequest $request): bool
    {
        if ($user->isManager()) {
            return true;
        }

        if (! $request->recipientAccount) {
            return false;
        }

        return $this->canAccessAccount($user, $request->recipientAccount);
    }

    public function create(User $user): bool
    {
        return $user->isManager();
    }
}
