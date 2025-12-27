<?php

namespace App\Http\Livewire\HostingServices;

use App\Models\Account;
use App\Models\HostingPlan;
use App\Models\HostingService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Form extends Component
{
    use AuthorizesRequests;

    /** @var HostingService */
    public $service;

    public $account_id = '';
    public $hosting_plan_id = '';
    public $start_date = '';
    public $renewal_date = '';
    public $discount_percent = null;
    public $status = 'active';
    public $cancellation_requested_at = null;
    public $cancellation_confirmed_at = null;
    public $observations = null;

    public function mount(?HostingService $hostingService = null)
    {
        $this->service = $hostingService ?: new HostingService();

        if ($this->service->exists) {
            if (auth()->user()) {
                $this->authorize('update', $this->service);
            }
            $this->fill($this->service->only([
                'account_id',
                'hosting_plan_id',
                'start_date',
                'renewal_date',
                'discount_percent',
                'status',
                'cancellation_requested_at',
                'cancellation_confirmed_at',
                'observations',
            ]));
        } else {
            if (auth()->user()) {
                $this->authorize('create', HostingService::class);
            }
        }
    }

    public function save()
    {
        $data = $this->validate([
            'account_id' => 'required|uuid|exists:accounts,id',
            'hosting_plan_id' => 'required|uuid|exists:hosting_plans,id',
            'start_date' => 'required|date',
            'renewal_date' => 'required|date',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
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
                $this->authorize('create', HostingService::class);
            }
            $this->service = HostingService::query()->create($data);
        }

        return redirect()->route('crm.hosting.index');
    }

    public function render()
    {
        return view('livewire.hosting-services.form', [
            'accounts' => Account::query()->orderBy('name')->get(),
            'plans' => HostingPlan::query()->where('active', true)->orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}
