<?php

namespace App\Mail;

use App\Services\EmailTemplateRenderer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RenewalSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var array */
    public $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function build()
    {
        $renderer = new EmailTemplateRenderer();
        $list = '<ul>' . implode('', array_map(function ($item) {
            return '<li>' . e($item) . '</li>';
        }, $this->items)) . '</ul>';

        $content = $renderer->render('renewal_summary', [
            'items' => $list,
        ]);

        return $this->subject($content['subject'])
            ->html($content['body']);
    }
}
