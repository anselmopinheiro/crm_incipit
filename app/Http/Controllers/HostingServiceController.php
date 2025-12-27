<?php

namespace App\Http\Controllers;

use App\Models\HostingService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class HostingServiceController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = $request->user();
        $query = HostingService::query()->with(['account', 'plan']);

        if ($user) {
            $this->authorize('viewAny', HostingService::class);
        }

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
        $this->authorize('create', HostingService::class);

        $data = $request->validate([
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

        $service = HostingService::query()->create($data);

        return response()->json($service, 201);
    }

    public function show(HostingService $hostingService)
    {
        if (request()->user()) {
            $this->authorize('view', $hostingService);
        }

        return response()->json($hostingService->load(['account', 'plan', 'serviceTerms']));
    }

    public function update(Request $request, HostingService $hostingService)
    {
        $this->authorize('update', $hostingService);

        $data = $request->validate([
            'account_id' => 'sometimes|required|uuid|exists:accounts,id',
            'hosting_plan_id' => 'sometimes|required|uuid|exists:hosting_plans,id',
            'start_date' => 'sometimes|required|date',
            'renewal_date' => 'sometimes|required|date',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'status' => 'sometimes|required|in:active,renewal_pending,cancelled,expired',
            'cancellation_requested_at' => 'nullable|date',
            'cancellation_confirmed_at' => 'nullable|date',
            'observations' => 'nullable|string',
        ]);

        $hostingService->update($data);

        return response()->json($hostingService);
    }

    public function destroy(HostingService $hostingService)
    {
        $this->authorize('delete', $hostingService);

        $hostingService->delete();

        return response()->json(['status' => 'deleted']);
    }
}
