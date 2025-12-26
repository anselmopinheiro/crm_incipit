<?php

namespace App\Jobs;

use App\Mail\RenewalSummaryMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRenewalSummaryEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var array */
    private $emails;
    /** @var array */
    private $items;

    public function __construct(array $emails, array $items)
    {
        $this->emails = $emails;
        $this->items = $items;
    }

    public function handle()
    {
        if (! $this->emails || ! $this->items) {
            return;
        }

        Mail::to($this->emails)->send(new RenewalSummaryMail($this->items));
    }
}
