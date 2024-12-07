<?php

namespace App\Services;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendMail(string $to, string $subject, string $body)
    {
        $email = (new Email())
            ->from('noreply@example.com')
            ->to($to)
            ->subject($subject)
            ->html($body);

        $this->mailer->send($email);
    }
}
