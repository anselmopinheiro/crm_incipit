<?php

namespace App\Policies;

use App\Models\NotificationSetting;
use App\Models\User;
use App\Policies\Concerns\RespectsRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationSettingPolicy
{
    use HandlesAuthorization;
    use RespectsRoles;

    public function view(User $user, NotificationSetting $setting): bool
    {
        return $user->isManager();
    }

    public function update(User $user, NotificationSetting $setting): bool
    {
        return $user->isManager();
    }
}
