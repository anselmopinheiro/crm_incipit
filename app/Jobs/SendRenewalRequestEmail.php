<?php

namespace App\Jobs;

use App\Mail\RenewalRequestMail;
use App\Models\RenewalRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRenewalRequestEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var string */
    private $renewalRequestId;

    public function __construct(string $renewalRequestId)
    {
        $this->renewalRequestId = $renewalRequestId;
    }

    public function handle()
    {
        $renewalRequest = RenewalRequest::with(['serviceTerm.service', 'recipientAccount'])->find($this->renewalRequestId);

        if (! $renewalRequest || ! $renewalRequest->recipientAccount) {
            return;
        }

        $email = $renewalRequest->recipientAccount->email_billing;
        if (! $email) {
            return;
        }

        Mail::to($email)
            ->send(new RenewalRequestMail($renewalRequest));
    }
}
