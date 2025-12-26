<?php

namespace App\Http\Controllers;

use App\Models\DomainService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class DomainServiceController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', DomainService::class);

        $user = $request->user();
        $query = DomainService::query()->with(['account', 'tld']);

        if ($user && ($user->isReseller() || $user->isClient())) {
            $query->whereHas('account', function ($builder) use ($user) {
                $builder->where('id', $user->account_id)
                    ->orWhere('reseller_account_id', $user->account_id);
            });
        }

        return response()->json($query->paginate(25));
    }

    public function store(Request $request)
    {
        $this->authorize('create', DomainService::class);

        $data = $request->validate([
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

        $service = DomainService::query()->create($data);

        return response()->json($service, 201);
    }

    public function show(DomainService $domainService)
    {
        $this->authorize('view', $domainService);

        return response()->json($domainService->load(['account', 'tld', 'serviceTerms']));
    }

    public function update(Request $request, DomainService $domainService)
    {
        $this->authorize('update', $domainService);

        $data = $request->validate([
            'account_id' => 'sometimes|required|uuid|exists:accounts,id',
            'domain_name' => 'sometimes|required|string|max:255',
            'tld_id' => 'sometimes|required|uuid|exists:tlds,id',
            'start_date' => 'sometimes|required|date',
            'renewal_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:active,renewal_pending,cancelled,expired',
            'cancellation_requested_at' => 'nullable|date',
            'cancellation_confirmed_at' => 'nullable|date',
            'observations' => 'nullable|string',
        ]);

        $domainService->update($data);

        return response()->json($domainService);
    }

    public function destroy(DomainService $domainService)
    {
        $this->authorize('delete', $domainService);

        $domainService->delete();

        return response()->json(['status' => 'deleted']);
    }
}
