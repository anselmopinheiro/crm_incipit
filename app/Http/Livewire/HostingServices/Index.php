<?php

namespace App\Http\Livewire\HostingServices;

use App\Models\HostingService;
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
            $this->authorize('viewAny', HostingService::class);
        }

        $query = HostingService::query()->with(['account', 'plan'])->latest();
        $user = auth()->user();

        if ($user && ($user->isReseller() || $user->isClient())) {
            $query->whereHas('account', function ($builder) use ($user) {
                $builder->where('id', $user->account_id)
                    ->orWhere('reseller_account_id', $user->account_id);
            });
        }

        return view('livewire.hosting-services.index', [
            'services' => $query->paginate(15),
        ])->layout('layouts.app');
    }
}
