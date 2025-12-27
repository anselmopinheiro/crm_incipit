<?php

namespace App\Http\Controllers;

use App\Jobs\SendRenewalResponseNotification;
use App\Models\RenewalRequest;
use App\Models\User;
use App\Support\Role;
use Illuminate\Http\Request;

class RenewalResponseController extends Controller
{
    public function show(string $token)
    {
        $renewalRequest = RenewalRequest::with(['serviceTerm.service', 'recipientAccount'])
            ->where('token', $token)
            ->firstOrFail();

        return view('renewals.respond', [
            'renewalRequest' => $renewalRequest,
        ]);
    }

    public function respond(Request $request, string $token)
    {
        $renewalRequest = RenewalRequest::with(['serviceTerm.service', 'recipientAccount'])
            ->where('token', $token)
            ->firstOrFail();

        $validated = $request->validate([
            'response' => 'required|in:renew_yes,renew_no,contact_me',
            'response_notes' => 'nullable|string',
        ]);

        $renewalRequest->response = $validated['response'];
        $renewalRequest->response_notes = $validated['response_notes'] ?? null;
        $renewalRequest->responded_at = now();
        $renewalRequest->status = 'responded';
        $renewalRequest->save();

        $emails = User::query()
            ->whereIn('role', [Role::ADMIN, Role::MANAGER])
            ->pluck('email')
            ->filter()
            ->all();

        SendRenewalResponseNotification::dispatch($renewalRequest->id, $emails);

        return view('renewals.thank-you');
    }
}
