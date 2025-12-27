<?php

namespace App\Mail;

use App\Models\RenewalRequest;
use App\Services\EmailTemplateRenderer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RenewalResponseMail extends Mailable
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

        $content = $renderer->render('renewal_response', [
            'account_name' => $account ? $account->name : '',
            'service_label' => $term ? $term->serviceLabel() : '',
            'response' => $this->renewalRequest->response ?? '',
            'response_notes' => $this->renewalRequest->response_notes ?? '',
        ]);

        return $this->subject($content['subject'])
            ->html($content['body']);
    }
}
