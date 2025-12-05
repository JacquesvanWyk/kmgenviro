<?php

namespace App\Mail;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;

class UseSendTransport extends AbstractTransport
{
    public function __construct(
        private string $apiKey
    ) {
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $to = collect($email->getTo())->map(fn($addr) => $addr->getAddress())->first();
        $from = collect($email->getFrom())->map(fn($addr) => $addr->getAddress())->first();

        Http::withToken($this->apiKey)
            ->post('https://app.usesend.com/api/v1/emails', [
                'to' => $to,
                'from' => $from,
                'subject' => $email->getSubject(),
                'html' => $email->getHtmlBody(),
                'text' => $email->getTextBody(),
            ]);
    }

    public function __toString(): string
    {
        return 'usesend';
    }
}
