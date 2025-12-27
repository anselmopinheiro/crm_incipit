<?php

namespace App\Http\Livewire\DomainServices;

use App\Models\Account;
use App\Models\DomainService;
use App\Models\Tld;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Form extends Component
{
    use AuthorizesRequests;

    /** @var DomainService */
    public $service;

    public $account_id = '';
    public $domain_name = '';
    public $tld_id = '';
    public $start_date = '';
    public $renewal_date = '';
    public $status = 'active';
    public $cancellation_requested_at = null;
    public $cancellation_confirmed_at = null;
    public $observations = null;

    public function mount(?DomainService $domainService = null)
    {
        $this->service = $domainService ?: new DomainService();

        if ($this->service->exists) {
            if (auth()->user()) {
                $this->authorize('update', $this->service);
            }
            $this->fill($this->service->only([
                'account_id',
                'domain_name',
                'tld_id',
                'start_date',
                'renewal_date',
                'status',
                'cancellation_requested_at',
                'cancellation_confirmed_at',
                'observations',
            ]));
        } else {
            if (auth()->user()) {
                $this->authorize('create', DomainService::class);
            }
        }
    }

    public function save()
    {
        $data = $this->validate([
            'account_id' => 'required|uuid|exists:accounts,id',
            'domain_name' => 'required|string|max:255',
            'tld_id' => 'required|uuid|exists:tlds,id',
            'start_date' => 'required|date',
            'renewal_date' => 'required|date',
            'status' => 'required|in:active,renewal_pending,cancelled,expired',
            'cancellation_requested_at' => 'nullable|date',
            'cancellation_confirmed_at' => 'nullable|date',
            'observations' => 'nullable|string',
        ]);

        if ($this->service->exists) {
            if (auth()->user()) {
                $this->authorize('update', $this->service);
            }
            $this->service->update($data);
        } else {
            if (auth()->user()) {
                $this->authorize('create', DomainService::class);
            }
            $this->service = DomainService::query()->create($data);
        }

        return redirect()->route('crm.domains.index');
    }

    public function render()
    {
        return view('livewire.domain-services.form', [
            'accounts' => Account::query()->orderBy('name')->get(),
            'tlds' => Tld::query()->where('active', true)->orderBy('tld')->get(),
        ])->layout('layouts.app');
    }
}
