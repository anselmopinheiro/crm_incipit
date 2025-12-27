<?php

namespace App\Http\Livewire\Accounts;

use App\Models\Account;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public function delete(string $accountId)
    {
        $account = Account::query()->findOrFail($accountId);

        if (auth()->user()) {
            $this->authorize('delete', $account);
        }

        $account->delete();

        $this->resetPage();
    }

    public function render()
    {
        if (auth()->user()) {
            $this->authorize('viewAny', Account::class);
        }

        $query = Account::query()->orderBy('name');
        $user = auth()->user();

        if ($user && ($user->isReseller() || $user->isClient())) {
            $query->where(function ($builder) use ($user) {
                $builder->where('id', $user->account_id)
                    ->orWhere('reseller_account_id', $user->account_id);
            });
        }

        return view('livewire.accounts.index', [
            'accounts' => $query->paginate(15),
        ])->layout('layouts.app');
    }
}
