<?php

namespace App\Mail;

use App\Models\RenewalRequest;
use App\Services\EmailTemplateRenderer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RenewalRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var RenewalRequest */
    public $renewalRequest;

    public function __construct(RenewalRequest $renewalRequest)
    {
        $this->renewalRequest = $renewalRequest;
    }

    public function build()
    {
        $term = $this->renewalRequest->serviceTerm;
        $account = $this->renewalRequest->recipientAccount;
        $renderer = new EmailTemplateRenderer();
        $responseUrl = route('renewals.respond', $this->renewalRequest->token);

        $content = $renderer->render('renewal_request', [
            'account_name' => $account ? $account->name : '',
            'service_label' => $term ? $term->serviceLabel() : '',
            'period_end' => $term ? $term->period_end->format('Y-m-d') : '',
            'response_url' => $responseUrl,
        ]);

        return $this->subject($content['subject'])
            ->html($content['body']);
    }
}
