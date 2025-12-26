<?php

namespace App\Services;

use App\Models\EmailTemplate;

class EmailTemplateRenderer
{
    public function render(string $key, array $data = []): array
    {
        $template = EmailTemplate::query()->where('key', $key)->where('active', true)->first();

        if (! $template) {
            return [
                'subject' => $key,
                'body' => '',
            ];
        }

        $subject = $this->interpolate($template->subject, $data);
        $body = $this->interpolate($template->body, $data);

        return [
            'subject' => $subject,
            'body' => $body,
        ];
    }

    private function interpolate(string $value, array $data): string
    {
        foreach ($data as $key => $replacement) {
            $value = str_replace('{{' . $key . '}}', (string) $replacement, $value);
        }

        return $value;
    }
}
