<?php

namespace App\Http\Livewire\DomainServices;

use App\Models\DomainService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public function render()
    {
        if (auth()->user()) {
            $this->authorize('viewAny', DomainService::class);
        }

        $query = DomainService::query()->with(['account', 'tld'])->latest();
        $user = auth()->user();

        if ($user && ($user->isReseller() || $user->isClient())) {
            $query->whereHas('account', function ($builder) use ($user) {
                $builder->where('id', $user->account_id)
                    ->orWhere('reseller_account_id', $user->account_id);
            });
        }

        return view('livewire.domain-services.index', [
            'services' => $query->paginate(15),
        ])->layout('layouts.app');
    }
}
