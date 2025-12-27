<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = $request->user();
        $query = Account::query();

        if ($user) {
            $this->authorize('viewAny', Account::class);
        }

        if ($user && ($user->isReseller() || $user->isClient())) {
            $query->where(function ($builder) use ($user) {
                $builder->where('id', $user->account_id)
                    ->orWhere('reseller_account_id', $user->account_id);
            });
        }

        return response()->json($query->paginate(25));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Account::class);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'vat' => 'nullable|string|max:50',
            'email_billing' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'reseller_account_id' => 'nullable|uuid|exists:accounts,id',
            'status' => 'required|in:active,inactive',
            'observations' => 'nullable|string',
        ]);

        $account = Account::query()->create($data);

        return response()->json($account, 201);
    }

    public function show(Account $account)
    {
        if (request()->user()) {
            $this->authorize('view', $account);
        }

        return response()->json($account);
    }

    public function update(Request $request, Account $account)
    {
        $this->authorize('update', $account);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'vat' => 'nullable|string|max:50',
            'email_billing' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'reseller_account_id' => 'nullable|uuid|exists:accounts,id',
            'status' => 'sometimes|required|in:active,inactive',
            'observations' => 'nullable|string',
        ]);

        $account->update($data);

        return response()->json($account);
    }

    public function destroy(Account $account)
    {
        $this->authorize('delete', $account);

        $account->delete();

        return response()->json(['status' => 'deleted']);
    }
}
