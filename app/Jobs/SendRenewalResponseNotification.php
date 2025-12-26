<?php

namespace App\Jobs;

use App\Mail\RenewalResponseMail;
use App\Models\RenewalRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRenewalResponseNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var string */
    private $renewalRequestId;
    /** @var array */
    private $emails;

    public function __construct(string $renewalRequestId, array $emails)
    {
        $this->renewalRequestId = $renewalRequestId;
        $this->emails = $emails;
    }

    public function handle()
    {
        if (! $this->emails) {
            return;
        }

        $renewalRequest = RenewalRequest::with(['serviceTerm.service', 'recipientAccount'])->find($this->renewalRequestId);

        if (! $renewalRequest) {
            return;
        }

        Mail::to($this->emails)->send(new RenewalResponseMail($renewalRequest));
    }
}
