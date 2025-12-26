<?php

namespace App\Policies;

use App\Models\EmailTemplate;
use App\Models\User;
use App\Policies\Concerns\RespectsRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmailTemplatePolicy
{
    use HandlesAuthorization;
    use RespectsRoles;

    public function viewAny(User $user): bool
    {
        return $user->isManager();
    }

    public function view(User $user, EmailTemplate $template): bool
    {
        return $user->isManager();
    }

    public function update(User $user, EmailTemplate $template): bool
    {
        return $user->isManager();
    }
}
