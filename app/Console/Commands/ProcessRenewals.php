<?php

namespace App\Console\Commands;

use App\Jobs\SendRenewalRequestEmail;
use App\Jobs\SendRenewalSummaryEmail;
use App\Models\NotificationSetting;
use App\Models\RenewalRequest;
use App\Models\ServiceTerm;
use App\Models\User;
use App\Support\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;

class ProcessRenewals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renewals:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processa renovações pendentes e notificações.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $settings = NotificationSetting::query()->firstOrCreate([], [
            'internal_notify_days_before' => 30,
            'customer_notify_days_before' => 30,
            'resend_every_days' => 5,
            'max_resends' => 6,
        ]);

        $today = now()->startOfDay();
        $customerWindowEnd = $today->copy()->addDays($settings->customer_notify_days_before);
        $internalWindowEnd = $today->copy()->addDays($settings->internal_notify_days_before);
        $windowEnd = $customerWindowEnd->greaterThan($internalWindowEnd) ? $customerWindowEnd : $internalWindowEnd;

        $terms = ServiceTerm::query()
            ->with(['service', 'service.account'])
            ->where('status', 'pending_confirmation')
            ->whereDate('period_end', '>=', $today)
            ->whereDate('period_end', '<=', $windowEnd)
            ->get();

        $summaryItems = [];
        $requestsToDispatch = [];

        foreach ($terms as $term) {
            $service = $term->service;
            if (! $service || ! $service->account) {
                continue;
            }

            if (! in_array($service->status, ['active', 'renewal_pending'], true)) {
                continue;
            }

            $account = $service->account;
            $recipientAccount = $account->reseller_account_id ? $account->resellerAccount : $account;
            $recipientType = $account->reseller_account_id ? 'reseller' : 'client';

            if (! $recipientAccount) {
                continue;
            }

            if ($term->period_end->lessThanOrEqualTo($internalWindowEnd)) {
                $summaryItems[] = sprintf('%s - %s (%s)', $account->name, $term->serviceLabel(), $term->period_end->format('Y-m-d'));
            }

            $exists = RenewalRequest::query()
                ->where('service_term_id', $term->id)
                ->where('recipient_account_id', $recipientAccount->id)
                ->exists();

            if (! $exists && $term->period_end->lessThanOrEqualTo($customerWindowEnd)) {
                $request = RenewalRequest::query()->create([
                    'service_term_id' => $term->id,
                    'recipient_type' => $recipientType,
                    'recipient_account_id' => $recipientAccount->id,
                    'token' => Str::random(40),
                    'status' => 'pending_send',
                    'next_send_at' => now(),
                ]);

            }
        }

        if ($summaryItems) {
            $emails = User::query()
                ->whereIn('role', [Role::ADMIN, Role::MANAGER])
                ->pluck('email')
                ->filter()
                ->all();

            SendRenewalSummaryEmail::dispatch($emails, $summaryItems);
        }

        $maxResends = $settings->max_resends;
        $resendEveryDays = $settings->resend_every_days;

        $pendingRequests = RenewalRequest::query()
            ->with(['recipientAccount', 'serviceTerm.service'])
            ->whereNull('response')
            ->where(function ($query) {
                $query->where('status', 'pending_send')
                    ->orWhere(function ($sub) {
                        $sub->where('status', 'sent')
                            ->whereNotNull('next_send_at')
                            ->where('next_send_at', '<=', now());
                    });
            })
            ->get();

        foreach ($pendingRequests as $request) {
            if ($request->resend_count >= $maxResends) {
                $request->status = 'closed';
                $request->save();
                continue;
            }

            $sendAt = now();
            $request->first_sent_at = $request->first_sent_at ?: $sendAt;
            $request->last_sent_at = $sendAt;
            $request->next_send_at = $sendAt->copy()->addDays($resendEveryDays);
            $request->resend_count = $request->resend_count + 1;
            $request->status = 'sent';
            $request->save();

            $requestsToDispatch[] = $request;
        }

        if ($requestsToDispatch) {
            Bus::batch(collect($requestsToDispatch)->map(function ($request) {
                return new SendRenewalRequestEmail($request->id);
            }))->dispatch();
        }

        return 0;
    }
}
