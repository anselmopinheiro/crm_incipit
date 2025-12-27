<?php

namespace App\Http\Livewire\Accounts;

use App\Models\Account;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Form extends Component
{
    use AuthorizesRequests;

    /** @var Account */
    public $account;

    public $name = '';
    public $vat = null;
    public $email_billing = null;
    public $phone = null;
    public $address = null;
    public $reseller_account_id = null;
    public $status = 'active';
    public $observations = null;

    public function mount(?Account $account = null)
    {
        $this->account = $account ?: new Account();

        if ($this->account->exists) {
            if (auth()->user()) {
                $this->authorize('update', $this->account);
            }
            $this->fill($this->account->only([
                'name',
                'vat',
                'email_billing',
                'phone',
                'address',
                'reseller_account_id',
                'status',
                'observations',
            ]));
        } else {
            if (auth()->user()) {
                $this->authorize('create', Account::class);
            }
        }
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'vat' => 'nullable|string|max:50',
            'email_billing' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'reseller_account_id' => 'nullable|uuid|exists:accounts,id',
            'status' => 'required|in:active,inactive',
            'observations' => 'nullable|string',
        ]);

        if ($this->account->exists) {
            if (auth()->user()) {
                $this->authorize('update', $this->account);
            }
            $this->account->update($data);
        } else {
            if (auth()->user()) {
                $this->authorize('create', Account::class);
            }
            $this->account = Account::query()->create($data);
        }

        return redirect()->route('crm.accounts.index');
    }

    public function render()
    {
        return view('livewire.accounts.form', [
            'resellers' => Account::query()->orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}
