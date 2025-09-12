<?php

namespace App\Licensing\Domain\Service;

use App\Licensing\Domain\Model\Client\ClientWasCreated;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class ClientNotificatorService
{
    public function __construct(private MailerInterface $mailer)
    {

    }

    public function onClientCreated(ClientWasCreated $event): void
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
    }
}
