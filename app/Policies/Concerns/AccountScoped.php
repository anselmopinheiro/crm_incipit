<?php

namespace App\Policies\Concerns;

use App\Models\Account;
use App\Models\User;

trait AccountScoped
{
    protected function canAccessAccount(User $user, Account $account): bool
    {
        if ($user->isReseller()) {
            return $user->account_id === $account->id || $account->reseller_account_id === $user->account_id;
        }

        if ($user->isClient()) {
            return $user->account_id === $account->id;
        }

        return false;
    }
}
