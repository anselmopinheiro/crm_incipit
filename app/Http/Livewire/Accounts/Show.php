<?php

namespace App\Http\Livewire\Accounts;

use App\Models\Account;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    /** @var Account */
    public $account;

    public function mount(Account $account)
    {
        $this->authorize('view', $account);

        $this->account = $account->load([
            'hostingServices.plan',
            'hostingServices.serviceTerms',
            'domainServices.tld',
            'domainServices.serviceTerms',
            'resellerAccount',
        ]);
    }

    public function render()
    {
        $terms = $this->account->hostingServices->flatMap(function ($service) {
            return $service->serviceTerms->map(function ($term) use ($service) {
                return [
                    'term' => $term,
                    'service' => $service,
                    'type' => 'hosting',
                ];
            });
        })->merge($this->account->domainServices->flatMap(function ($service) {
            return $service->serviceTerms->map(function ($term) use ($service) {
                return [
                    'term' => $term,
                    'service' => $service,
                    'type' => 'domain',
                ];
            });
        }))->sortBy(function ($item) {
            return $item['term']->period_end;
        });

        $grouped = $terms->groupBy(function ($item) {
            return $item['term']->period_end->format('Y-m-d');
        });

        return view('livewire.accounts.show', [
            'groupedTerms' => $grouped,
        ])->layout('layouts.app');
    }
}
